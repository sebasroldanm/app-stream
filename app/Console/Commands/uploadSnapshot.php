<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Snapshot;
use App\Models\PictureUpload;
use Illuminate\Support\Facades\Storage;

class uploadSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-snapshot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://static-cdn.strpst.com/photos/7/c/6/7c66eb5d3bb281d62f0ee984bbb18bfa-full';

        $response = Http::get($url);
        $response->throw();

        $contents = $response->body();

        $content_base64 = base64_encode($contents);
        
        $response = Http::timeout(60)
            ->asForm()
            ->post(config('services.imgbb.endpoint'), [
                'key'   => config('services.imgbb.key'),
                'image' => $content_base64,
            ]);


        dd($response->status(), $response->json());


        $sanps = Snapshot::where('picture_upload_id', '')
            ->where('owner_id', '174871334')
            ->limit(20)
            ->get();

        foreach ($sanps as $s) {
            $imagePath = public_path($s->local_url); // Obtener la ruta completa de la imagen
            if (file_exists($imagePath)) {
                try {
                    $image = base64_encode(file_get_contents($imagePath)); // Leer y codificar en base64

                    $response = Http::timeout(60)->asForm()->post(config('services.imgbb.endpoint') . '?key=' . config('services.imgbb.key'), [
                        'image' => $image,
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

                        $id = $pic->id;
                        $update = Snapshot::where('id', $s->id)->update(['picture_upload_id' => $id]);
                        // Eliminar el archivo local después de la carga
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    } else {
                        dd('Error in response: ' . $response->body());
                        $url = null;
                    }
                } catch (\Exception $e) {
                    dd('Exception occurred: ' . $e->getMessage());
                    $url = null;
                }
            } else {
                $image = null; // Manejar el caso en que el archivo no exista
            }
            sleep(3); // Esperar 3 segundo entre cada solicitud 
        }
    }


    /**
 * Devuelve la extensión de archivo asociada a un MIME type.
 *
 * @param  string  $mime  El MIME type (p.ej. "image/jpeg")
 * @return string         La extensión recomendada (p.ej. "jpg")
 */
function extensionFromMime(string $mime): string
{
    // 1. Mapeo de los tipos más comunes
    static $map = [
        'image/jpeg'             => 'jpg',
        'image/png'              => 'png',
        'image/gif'              => 'gif',
        'image/webp'             => 'webp',
        'image/bmp'              => 'bmp',
        'image/svg+xml'          => 'svg',
        'image/vnd.microsoft.icon'=> 'ico',
    ];

    // 2. Si está en el mapeo, lo devolvemos
    if (isset($map[$mime])) {
        return $map[$mime];
    }

    // 3. Fallback: tomamos la parte después de la "/"
    //    Ej. "application/json" => "json"
    if (strpos($mime, '/') !== false) {
        return explode('/', $mime, 2)[1];
    }

    // 4. Valor por defecto si no podemos determinarlo
    return 'bin';
}
}
