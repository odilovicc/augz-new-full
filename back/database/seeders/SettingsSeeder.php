<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(['slug' => 'settings'], ['content' => $this->defaultSettings()]);
    }

    private function defaultSettings(): array
    {
        return [
            'contacts' => [
                'phone'    => '+998 55 503 12 21',
                'email'    => 'info@augz.uz',
                'telegram' => '@augz_uz',
                'telegram_url' => 'https://t.me/augz_uz',
            ],

            'address' => [
                'text'    => 'г. Ташкент, Мирабадский район, ул. Нукуса, 89',
                'zip'     => '100000',
                'maps_url' => 'https://yandex.uz/maps/-/CHfbmkAB',
                'lat'     => 41.2986,
                'lng'     => 69.2757,
            ],

            'hours' => [
                'days'  => 'Пн–Пт',
                'from'  => '09:00',
                'to'    => '18:00',
            ],

            'socials' => [
                ['id' => 'telegram',  'name' => 'Telegram',  'handle' => '@augz_uz',        'url' => 'https://t.me/augz_uz',                              'icon' => 'mdi:send'],
                ['id' => 'facebook',  'name' => 'Facebook',  'handle' => 'augz.uz',          'url' => 'https://facebook.com/augz.uz',                      'icon' => 'mdi:facebook'],
                ['id' => 'instagram', 'name' => 'Instagram', 'handle' => '@augz_uz',         'url' => 'https://instagram.com/augz_uz',                     'icon' => 'mdi:instagram'],
                ['id' => 'linkedin',  'name' => 'LinkedIn',  'handle' => 'augz-uzbekistan',  'url' => 'https://linkedin.com/company/augz-uzbekistan',      'icon' => 'mdi:linkedin'],
                ['id' => 'youtube',   'name' => 'YouTube',   'handle' => 'АУГЗ Канал',       'url' => 'https://youtube.com/@augz',                         'icon' => 'mdi:youtube'],
            ],

            'departments' => [
                ['name' => 'Членство',        'desc' => 'Вступление, тарифы, продление',      'responsible' => 'Абидов Марат',              'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz'],
                ['name' => 'Обучение',        'desc' => 'Курсы, программы, сертификаты',      'responsible' => 'Учебный центр',             'phone' => '+998 55 503 12 21', 'email' => 'edu@augz.uz'],
                ['name' => 'Консалтинг',      'desc' => 'Тендерная помощь, документы',        'responsible' => 'Абидов Марат',              'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz'],
                ['name' => 'Правовая защита', 'desc' => 'Обжалование, юридические споры',     'responsible' => 'Абидов Марат',              'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz'],
                ['name' => 'Пресс-служба',    'desc' => 'СМИ, партнёрства, PR',               'responsible' => 'Пресс-служба',              'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz'],
                ['name' => 'TenderZone',      'desc' => 'Техподдержка',                       'responsible' => 'Тех специалист TenderZone', 'phone' => '+998 55 516 52 25', 'email' => 'info.newtenderzone.uz@gmail.com'],
            ],
        ];
    }
}
