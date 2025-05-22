<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Device;
use App\Models\Vendor;
use League\Csv\Reader;
use App\Models\DeviceAlias;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FeedParserService
{

    public function process(Vendor $vendor): void
    {
        $parsed = $matched = $unmatched = $skipped = 0;

        // Clear previous CSVs
        $paths = [
            'raw' => storage_path("app/vendor_feeds/raw_{$vendor->id}.csv"),
            'unmatched' => storage_path("app/vendor_feeds/unmatched_{$vendor->id}.csv"),
        ];

        foreach ($paths as $label => $path) {
            if (file_exists($path)) {
                try {
                    unlink($path);
                    \Log::info("Deleted old {$label} feed for vendor {$vendor->id}");
                } catch (\Throwable $e) {
                    \Log::warning("Failed to delete {$label} feed for vendor {$vendor->id}: {$e->getMessage()}");
                }
            }
        }
        

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
                $parsed++;
                $result = $this->processRecord($record, $vendor);

                match ($result) {
                    'matched' => $matched++,
                    'unmatched' => $unmatched++,
                    'skipped', 'invalid' => $skipped++,
                    default => null,
                };
            }

        } catch (\Throwable $e) {
            Log::error("Error parsing feed for vendor {$vendor->id}: " . $e->getMessage());
        }

        \App\Models\FeedLog::create([
            'vendor_id' => $vendor->id,
            'offers_total' => $parsed,
            'offers_matched' => $matched,
            'offers_unmatched' => $unmatched,
            'offers_skipped' => $skipped,
        ]);
    }

    protected function processRecord(array $record, Vendor $vendor): string
    {
        if (!isset($record['product'], $record['price'], $record['network'], $record['condition'])) {
            Log::warning("Skipping invalid row: missing fields");
            return 'invalid';
        }

        if ((float) $record['price'] <= 0) {
            return 'skipped';
        }

        $match = $this->matchDevice($record['product']);
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

            return 'unmatched';
        }

        $existing = Offer::where([
            'vendor_id' => $vendor->id,
            'device_id' => $device->id,
            'network' => $record['network'],
        ])->first();

        if ($existing && $existing->match_method === 'manual') {
            return 'skipped';
        }

        Offer::updateOrCreate([
            'vendor_id' => $vendor->id,
            'device_id' => $device->id,
            'network' => $record['network'],
            'condition' => $record['condition'],
        ], [
            'price' => $record['price'],
            'vendor_product_id' => $record['vendor_product_id'] ?? null,
            'product_url' => $record['link'] ?? null,
            'category' => $record['category'] ?? 'phone',
            'valid_until' => now()->addDays(1),
            'match_method' => $method,
        ]);

        return 'matched';
    }


   protected function matchDevice(string $product): array
    {
        $alias = DeviceAlias::where('alias', 'like', '%' . $product . '%')->first();

        if ($alias && $alias->device) {
            return ['device' => $alias->device, 'method' => 'alias'];
        }

        $candidates = Device::all();

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
