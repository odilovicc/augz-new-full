<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'sort_order'   => 1,
                'text'         => '«Благодаря АУГЗ мы выиграли три государственных тендера за год. Аналитика и поддержка — на высшем уровне.»',
                'author'       => 'Алишер Каримов',
                'role'         => 'Директор, ООО «ТендерПро»',
                'initials'     => 'АК',
                'avatar_color' => 'linear-gradient(135deg, #1e3a5f, #2d6a9f)',
                'translations' => [
                    'uz' => [
                        'text' => '«AUGZ tufayli biz bir yil ichida uchta davlat tenderini yutib oldik. Tahlil va qo\'llab-quvvatlash — eng yuqori darajada.»',
                        'role' => 'Direktor, "TenderPro" MChJ',
                    ],
                    'en' => [
                        'text' => '"Thanks to AUGZ, we won three government tenders in a year. Analytics and support are at the highest level."',
                        'role' => 'Director, TenderPro LLC',
                    ],
                ],
            ],
            [
                'sort_order'   => 2,
                'text'         => '«Обучение в АУГЗ полностью изменило наш подход к участию в госзакупках. Команда настоящих профессионалов.»',
                'author'       => 'Нилуфар Исмаилова',
                'role'         => 'Главный специалист, АО «УзТендер»',
                'initials'     => 'НИ',
                'avatar_color' => 'linear-gradient(135deg, #1a3a2a, #2d7a4f)',
                'translations' => [
                    'uz' => [
                        'text' => '«AUGZda o\'qitish davlat xaridlarida ishtirok etishga yondashuvimizni butunlay o\'zgartirdi. Haqiqiy mutaxassislar jamoasi.»',
                        'role' => 'Bosh mutaxassis, "UzTender" AJ',
                    ],
                    'en' => [
                        'text' => '"Training at AUGZ completely changed our approach to public procurement. A team of true professionals."',
                        'role' => 'Chief Specialist, UzTender JSC',
                    ],
                ],
            ],
            [
                'sort_order'   => 3,
                'text'         => '«Партнёрская сеть АУГЗ открыла нам двери к крупным корпоративным заказчикам по всему Узбекистану.»',
                'author'       => 'Фаррух Хасанов',
                'role'         => 'CEO, BuildGroup Uzbekistan',
                'initials'     => 'ФХ',
                'avatar_color' => 'linear-gradient(135deg, #3a1a1a, #7a2d2d)',
                'translations' => [
                    'uz' => [
                        'text' => '«AUGZ sheriklik tarmog\'i bizga butun O\'zbekiston bo\'ylab yirik korporativ buyurtmachilarga eshik ochdi.»',
                        'role' => 'Bosh direktor, BuildGroup Uzbekistan',
                    ],
                    'en' => [
                        'text' => '"The AUGZ partner network opened doors for us to major corporate clients across Uzbekistan."',
                        'role' => 'CEO, BuildGroup Uzbekistan',
                    ],
                ],
            ],
        ];

        foreach ($items as $data) {
            Testimonial::updateOrCreate(['author' => $data['author']], $data);
        }
    }
}
