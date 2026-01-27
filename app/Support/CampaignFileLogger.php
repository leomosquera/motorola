<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CampaignFileLogger
{
    public static function log(array $data): void
    {
        $data['ts'] = Carbon::now()->format('Y-m-d H:i:s');

        Storage::append(
            'logs/campaign-files.log',
            json_encode(
                $data,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            )
        );
    }
}
