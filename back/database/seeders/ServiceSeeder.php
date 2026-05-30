<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $base = rtrim(config('app.url'), '/');

        $services = [
            [
                'sort_order' => 1,
                'image'      => "{$base}/storage/pages/cons1.png",
                'title'      => 'Консультационные услуги',
                'tag'        => 'Консультации',
                'desc'       => 'Профессиональная поддержка по вопросам государственных закупок и тендерных процедур.',
                'translations' => [
                    'uz' => ['title' => 'Maslahat xizmatlari',      'tag' => 'Maslahat',          'desc' => "Davlat xaridlari va tender tartiblari bo'yicha professional yordam."],
                    'en' => ['title' => 'Consulting services',       'tag' => 'Consulting',        'desc' => 'Professional support on public procurement and tender procedures.'],
                ],
            ],
            [
                'sort_order' => 2,
                'image'      => "{$base}/storage/pages/cons2.png",
                'title'      => 'Обучение и повышение квалификации',
                'tag'        => 'Обучение',
                'desc'       => 'Курсы и семинары для специалистов в области государственных закупок.',
                'translations' => [
                    'uz' => ['title' => "Ta'lim va malaka oshirish", 'tag' => "Ta'lim",            'desc' => "Davlat xaridlari sohasidagi mutaxassislar uchun kurslar va seminarlar."],
                    'en' => ['title' => 'Training and upskilling',   'tag' => 'Training',          'desc' => 'Courses and seminars for public procurement specialists.'],
                ],
            ],
            [
                'sort_order' => 3,
                'image'      => "{$base}/storage/pages/cons3.png",
                'title'      => 'Аналитика и исследования',
                'tag'        => 'Аналитика',
                'desc'       => 'Глубокий анализ рынка государственных закупок и тендерных процедур.',
                'translations' => [
                    'uz' => ['title' => 'Tahlil va tadqiqotlar',     'tag' => 'Tahlil',            'desc' => 'Davlat xaridlari bozori va tender tartiblarining chuqur tahlili.'],
                    'en' => ['title' => 'Analytics and research',    'tag' => 'Analytics',         'desc' => 'In-depth analysis of the public procurement market and tender procedures.'],
                ],
            ],
            [
                'sort_order' => 4,
                'image'      => "{$base}/storage/pages/cons4.png",
                'title'      => 'Юридическая поддержка',
                'tag'        => 'Право',
                'desc'       => 'Правовое сопровождение участников тендерных и закупочных процедур.',
                'translations' => [
                    'uz' => ['title' => 'Yuridik yordam',            'tag' => 'Huquq',             'desc' => 'Tender va xarid tartibotlari ishtirokchilariga huquqiy yordam.'],
                    'en' => ['title' => 'Legal support',             'tag' => 'Legal',             'desc' => 'Legal support for participants in tender and procurement procedures.'],
                ],
            ],
            [
                'sort_order' => 5,
                'image'      => "{$base}/storage/pages/cons5.png",
                'title'      => 'Цифровые инструменты',
                'tag'        => 'Цифровые решения',
                'desc'       => 'IT-решения для автоматизации и оптимизации закупочных процессов.',
                'translations' => [
                    'uz' => ['title' => 'Raqamli vositalar',         'tag' => 'Raqamli yechimlar', 'desc' => "Xarid jarayonlarini avtomatlashtirish va optimallashtirish uchun IT yechimlar."],
                    'en' => ['title' => 'Digital tools',             'tag' => 'Digital',           'desc' => 'IT solutions to automate and optimize procurement processes.'],
                ],
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(
                ['title' => $data['title']],
                $data,
            );
        }
    }
}
