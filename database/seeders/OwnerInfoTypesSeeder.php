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
            ['key' => 'instagram_url', 'label' => 'Instagram', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'facebook_url', 'label' => 'Facebook', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'twitter_url', 'label' => 'X (Twitter)', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'tiktok_url', 'label' => 'TikTok', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'linkedin_url', 'label' => 'LinkedIn', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'youtube_channel', 'label' => 'YouTube', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'pinterest_url', 'label' => 'Pinterest', 'data_type' => 'url', 'category' => 'social'],
            ['key' => 'whatsapp_number', 'label' => 'WhatsApp', 'data_type' => 'number', 'category' => 'contact'],
            ['key' => 'telegram_user', 'label' => 'Telegram', 'data_type' => 'text', 'category' => 'contact'],
            ['key' => 'discord_server', 'label' => 'Discord', 'data_type' => 'url', 'category' => 'contact'],
            ['key' => 'secondary_email', 'label' => 'Email Secundario', 'data_type' => 'text', 'category' => 'contact'],
            ['key' => 'support_phone', 'label' => 'Teléfono', 'data_type' => 'number', 'category' => 'contact'],
            ['key' => 'address', 'label' => 'Dirección', 'data_type' => 'text', 'category' => 'contact'],
            ['key' => 'google_maps_link', 'label' => 'Ubicación (Maps)', 'data_type' => 'url', 'category' => 'contact'],
            ['key' => 'tax_id', 'label' => 'RUT / NIT / CUIT', 'data_type' => 'text', 'category' => 'contact'],
            ['key' => 'bank_account_info', 'label' => 'Datos Bancarios', 'data_type' => 'text', 'category' => 'business'],
        ];

        foreach ($types as $type) {
            OwnerInfoType::updateOrCreate(
                ['key' => $type['key']],
                $type
            );
        }
    }
}
