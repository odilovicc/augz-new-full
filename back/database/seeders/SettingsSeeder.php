<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Page::firstOrCreate(['slug' => 'settings'], ['content' => $this->defaultSettings()]);
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
                [
                    'name'        => ['ru' => 'Членство',        'uz' => "A'zolik",          'en' => 'Membership'],
                    'desc'        => ['ru' => 'Вступление, тарифы, продление', 'uz' => 'Kirish, tariflar, uzaytirish', 'en' => 'Joining, rates, renewal'],
                    'responsible' => ['ru' => 'Абидов Марат',    'uz' => 'Abidov Marat',     'en' => 'Abidov Marat'],
                    'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz',
                ],
                [
                    'name'        => ['ru' => 'Обучение',        'uz' => "Ta'lim",           'en' => 'Training'],
                    'desc'        => ['ru' => 'Курсы, программы, сертификаты', 'uz' => 'Kurslar, dasturlar, sertifikatlar', 'en' => 'Courses, programs, certificates'],
                    'responsible' => ['ru' => 'Учебный центр',   'uz' => "O'quv markazi",    'en' => 'Training Center'],
                    'phone' => '+998 55 503 12 21', 'email' => 'edu@augz.uz',
                ],
                [
                    'name'        => ['ru' => 'Консалтинг',      'uz' => 'Konsalting',       'en' => 'Consulting'],
                    'desc'        => ['ru' => 'Тендерная помощь, документы', 'uz' => 'Tender yordami, hujjatlar', 'en' => 'Tender assistance, documents'],
                    'responsible' => ['ru' => 'Абидов Марат',    'uz' => 'Abidov Marat',     'en' => 'Abidov Marat'],
                    'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz',
                ],
                [
                    'name'        => ['ru' => 'Правовая защита', 'uz' => 'Huquqiy himoya',   'en' => 'Legal Protection'],
                    'desc'        => ['ru' => 'Обжалование, юридические споры', 'uz' => 'Shikoyat, huquqiy nizolar', 'en' => 'Appeals, legal disputes'],
                    'responsible' => ['ru' => 'Абидов Марат',    'uz' => 'Abidov Marat',     'en' => 'Abidov Marat'],
                    'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz',
                ],
                [
                    'name'        => ['ru' => 'Пресс-служба',    'uz' => 'Matbuot xizmati',  'en' => 'Press Office'],
                    'desc'        => ['ru' => 'СМИ, партнёрства, PR', 'uz' => 'OAV, hamkorliklar, PR', 'en' => 'Media, partnerships, PR'],
                    'responsible' => ['ru' => 'Пресс-служба',    'uz' => 'Matbuot xizmati',  'en' => 'Press Office'],
                    'phone' => '+998 55 503 12 21', 'email' => 'info@augz.uz',
                ],
                [
                    'name'        => ['ru' => 'TenderZone',      'uz' => 'TenderZone',       'en' => 'TenderZone'],
                    'desc'        => ['ru' => 'Техподдержка',     'uz' => 'Texnik yordam',    'en' => 'Technical Support'],
                    'responsible' => ['ru' => 'Тех специалист TenderZone', 'uz' => 'TenderZone texnik mutaxassisi', 'en' => 'TenderZone Tech Specialist'],
                    'phone' => '+998 55 516 52 25', 'email' => 'info.newtenderzone.uz@gmail.com',
                ],
            ],
        ];
    }
}
