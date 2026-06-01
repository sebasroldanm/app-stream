<?php

namespace Database\Seeders;

use App\Models\OwnerInfoType;
use Illuminate\Database\Seeder;

class OwnerInfoTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['key' => 'instagram_url',      'label' => 'Instagram',         'data_type' => 'url',     'category' => 'social'],
            ['key' => 'facebook_url',       'label' => 'Facebook',          'data_type' => 'url',     'category' => 'social'],
            ['key' => 'x_url',              'label' => 'X',                 'data_type' => 'url',     'category' => 'social'],
            ['key' => 'tiktok_url',         'label' => 'TikTok',            'data_type' => 'url',     'category' => 'social'],
            ['key' => 'linkedin_url',       'label' => 'LinkedIn',          'data_type' => 'url',     'category' => 'social'],
            ['key' => 'youtube_channel',    'label' => 'YouTube',           'data_type' => 'url',     'category' => 'social'],
            ['key' => 'whatsapp_number',    'label' => 'WhatsApp',          'data_type' => 'number',  'category' => 'contact'],
            ['key' => 'telegram_user',      'label' => 'Telegram',          'data_type' => 'text',    'category' => 'contact'],
            ['key' => 'discord_server',     'label' => 'Discord',           'data_type' => 'url',     'category' => 'contact'],
            ['key' => 'secondary_email',    'label' => 'Email Secundario',  'data_type' => 'text',    'category' => 'contact'],
            ['key' => 'support_phone',      'label' => 'Teléfono',          'data_type' => 'number',  'category' => 'contact'],
            ['key' => 'address',            'label' => 'Dirección',         'data_type' => 'text',    'category' => 'contact'],
            ['key' => 'google_maps_link',   'label' => 'Ubicación (Maps)',  'data_type' => 'url',     'category' => 'contact'],
            ['key' => 'idn',                'label' => 'IDN',               'data_type' => 'text',    'category' => 'contact'],
            ['key' => 'finder_url',         'label' => 'Finder',            'data_type' => 'url',     'category' => 'personal'],
            ['key' => 'name',               'label' => 'Nombre',            'data_type' => 'text',    'category' => 'personal'],
            ['key' => 'last_name',          'label' => 'Apellido',          'data_type' => 'text',    'category' => 'personal'],
        ];

        foreach ($types as $type) {
            OwnerInfoType::updateOrCreate(
                ['key' => $type['key']],
                $type
            );
        }
    }
}
