<?php

namespace App\Services\Logger;

use Illuminate\Support\Facades\Log;

class ServiceLogger
{
    /**
     * Log an error to a dedicated service channel.
     *
     * @param string $channel The channel name (e.g., 'service/owner_video_sync')
     * @param string $message The error message
     * @param array $request Request details (url, params, etc)
     * @param array $response Response details (status, body, etc)
     * @param array|string $trace The exception trace
     */
    public function logError(string $channel, string $message, array $request = [], array $response = [], $trace = [])
    {
        $logPath = storage_path('logs/' . $channel . '.log');
        
        $directory = dirname($logPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $logger = Log::build([
            'driver' => 'daily',
            'path' => $logPath,
            'days' => 14,
        ]);

        $logger->error($message, [
            'request' => $request,
            'response' => $response,
            'trace' => $trace,
        ]);
    }
}
