<?php

namespace App\Jobs;

use App\Models\Vendor;
use App\Services\FeedParserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseVendorFeed implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Dispatchable;

    public function __construct(public Vendor $vendor) {}

    public function handle(FeedParserService $parser)
    {
        $parser->process($this->vendor);
    }
}

