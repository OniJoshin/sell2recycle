<?php

namespace App\Services;

use App\Models\Vendor;
use App\Models\Device;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class FeedParserService
{
    public function process(Vendor $vendor): void
    {
        if (!is_dir(storage_path('app/vendor_feeds'))) {
            mkdir(storage_path('app/vendor_feeds'), 0755, true);
        }

        if (!$vendor->feed_url) {
            Log::warning("Vendor {$vendor->id} has no feed URL.");
            return;
        }

        try {
            $response = Http::get($vendor->feed_url);

            if (!$response->ok()) {
                Log::error("Failed to fetch feed from {$vendor->feed_url}");
                return;
            }

            file_put_contents(
                storage_path("app/vendor_feeds/raw_{$vendor->id}.csv"),
                $response->body()
            );


            $csv = Reader::createFromString($response->body());
            $csv->setHeaderOffset(0);

            foreach ($csv as $record) {
                $this->processRecord($record, $vendor);
            }

        } catch (\Throwable $e) {
            Log::error("Error parsing feed for vendor {$vendor->id}: " . $e->getMessage());
        }
    }

    protected function processRecord(array $record, Vendor $vendor): void
    {
        if (!isset($record['product'], $record['price'], $record['network'], $record['condition'])) {
            Log::warning("Skipping invalid row: missing fields");
            return;
        }

        if ((float) $record['price'] <= 0) {
            return; // skip zero or negative prices
        }

        // Attempt to match product to a Device
        $match = $this->matchDevice($record['product'], $record['condition']);
        $device = $match['device'];
        $method = $match['method'];



        if (!$device) {
            Log::info("Unmatched product: " . $record['product']);

            $line = implode(',', [
                $record['product'] ?? '',
                $record['price'] ?? '',
                $record['network'] ?? '',
                $record['condition'] ?? '',
            ]);

            file_put_contents(
                storage_path("app/vendor_feeds/unmatched_{$vendor->id}.csv"),
                $line . PHP_EOL,
                FILE_APPEND
            );

            return;
        }


        $existing = Offer::where([
            'vendor_id' => $vendor->id,
            'device_id' => $device->id,
            'network' => $record['network'],
        ])->first();

        if ($existing && $existing->match_method === 'manual') {
            return; // skip updating this offer
        }

        Offer::updateOrCreate([
            'vendor_id' => $vendor->id,
            'device_id' => $device->id,
            'network' => $record['network'],
        ], [
            'price' => $record['price'],
            'valid_until' => now()->addDays(1),
            'match_method' => $method,
        ]);

    }

   protected function matchDevice(string $product, string $condition): array
    {
        $alias = \App\Models\DeviceAlias::where('alias', 'like', '%' . $product . '%')->first();

        if ($alias && $alias->device && $alias->device->condition === $condition) {
            return ['device' => $alias->device, 'method' => 'alias'];
        }

        $candidates = Device::where('condition', $condition)->get();

        $bestMatch = null;
        $bestScore = PHP_INT_MAX;

        foreach ($candidates as $device) {
            $fullName = "{$device->brand} {$device->model} {$device->storage}";
            $score = levenshtein(strtolower($product), strtolower($fullName));

            if ($score < $bestScore) {
                $bestScore = $score;
                $bestMatch = $device;
            }
        }

        if ($bestScore <= 15 && $bestMatch) {
            return ['device' => $bestMatch, 'method' => 'fuzzy'];
        }

        return ['device' => null, 'method' => null];
    }



}
