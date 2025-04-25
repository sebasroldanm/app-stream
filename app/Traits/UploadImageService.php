<?php

namespace App\Traits;

use App\Models\PictureUpload;
use Illuminate\Support\Facades\Http;

trait UploadImageService
{
    public function uploadImageByUrl($url)
    {

        $response = Http::timeout(60)
            ->asForm()
            ->post(config('services.imgbb.endpoint'), [
                'key'   => config('services.imgbb.key'),
                'image' => $url,
            ]);

        if ($response->successful() && isset($response['success']) && $response['success']) {
            $pic = PictureUpload::updateOrCreate(
                [
                    'id' => $response['data']['id'],
                ],
                [
                    'title' => $response['data']['title'],
                    'url_viewer' => $response['data']['url_viewer'],
                    'url' => $response['data']['url'],
                    'display_url' => $response['data']['display_url'],
                    'width' => $response['data']['width'],
                    'height' => $response['data']['height'],
                    'size' => $response['data']['size'],
                    'time' => $response['data']['time'],
                    'expiration' => $response['data']['expiration'],
                    'image_filename' => $response['data']['image']['filename'] ?? null,
                    'image_name' => $response['data']['image']['name'] ?? null,
                    'image_mime' => $response['data']['image']['mime'] ?? null,
                    'image_extension' => $response['data']['image']['extension'] ?? null,
                    'image_url' => $response['data']['image']['url'] ?? null,
                    'thumb_filename' => $response['data']['thumb']['filename'] ?? null,
                    'thumb_name' => $response['data']['thumb']['name'] ?? null,
                    'thumb_mime' => $response['data']['thumb']['mime'] ?? null,
                    'thumb_extension' => $response['data']['thumb']['extension'] ?? null,
                    'thumb_url' => $response['data']['thumb']['url'] ?? null,
                    'medium_filename' => $response['data']['medium']['filename'] ?? null,
                    'medium_name' => $response['data']['medium']['name'] ?? null,
                    'medium_mime' => $response['data']['medium']['mime'] ?? null,
                    'medium_extension' => $response['data']['medium']['extension'] ?? null,
                    'medium_url' => $response['data']['medium']['url'] ?? null,
                    'delete_url' => $response['data']['delete_url'],
                    'success' => $response['data']['success'] ?? null,
                    'status' => $response['data']['status'] ?? null,
                ]
            );

            return $pic->id;
        } else {
            return false;
        }

        return false;
    }
}