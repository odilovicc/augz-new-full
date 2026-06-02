<?php

namespace Database\Seeders;

use App\Models\FooterColumn;
use App\Models\FooterLink;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        FooterLink::query()->delete();
        FooterColumn::query()->delete();

        $columns = [
            [
                'title'    => ['ru' => 'О нас',    'uz' => 'Biz haqimizda', 'en' => 'About us'],
                'position' => 1,
                'links'    => [
                    ['label' => ['ru' => 'Об ассоциации', 'uz' => 'Assotsiatsiya haqida', 'en' => 'About the association'], 'href' => '/about'],
                    ['label' => ['ru' => 'Миссия и цели', 'uz' => 'Missiya va maqsadlar',  'en' => 'Mission & goals'],       'href' => '/about#mission'],
                    ['label' => ['ru' => 'Руководство',   'uz' => 'Rahbariyat',             'en' => 'Leadership'],             'href' => '/about#leaders'],
                    ['label' => ['ru' => 'Документы',     'uz' => 'Hujjatlar',              'en' => 'Documents'],              'href' => '/about#docs'],
                ],
            ],
            [
                'title'    => ['ru' => 'Услуги', 'uz' => 'Xizmatlar', 'en' => 'Services'],
                'position' => 2,
                'links'    => [
                    ['label' => ['ru' => 'Консультации',     'uz' => 'Konsultatsiyalar', 'en' => 'Consultations'],    'href' => '/services'],
                    ['label' => ['ru' => 'Правовая поддержка', 'uz' => 'Huquqiy yordam', 'en' => 'Legal support'],   'href' => '/services'],
                    ['label' => ['ru' => 'Обучение',         'uz' => "Ta'lim",            'en' => 'Training'],        'href' => '/services'],
                    ['label' => ['ru' => 'Аналитика',        'uz' => 'Tahlillar',         'en' => 'Analytics'],       'href' => '/services'],
                ],
            ],
            [
                'title'    => ['ru' => 'Членство', 'uz' => "A'zolik", 'en' => 'Membership'],
                'position' => 3,
                'links'    => [
                    ['label' => ['ru' => 'Как стать членом', 'uz' => "A'zo bo'lish",    'en' => 'How to join'],      'href' => '/membership'],
                    ['label' => ['ru' => 'Преимущества',     'uz' => 'Imtiyozlar',       'en' => 'Benefits'],         'href' => '/membership#benefits'],
                ],
            ],
            [
                'title'    => ['ru' => 'Информация', 'uz' => "Ma'lumot", 'en' => 'Information'],
                'position' => 4,
                'links'    => [
                    ['label' => ['ru' => 'Новости',     'uz' => 'Yangiliklar', 'en' => 'News'],       'href' => '/news'],
                    ['label' => ['ru' => 'Мероприятия', 'uz' => 'Tadbirlar',   'en' => 'Events'],     'href' => '/news'],
                    ['label' => ['ru' => 'Библиотека',  'uz' => 'Kutubxona',   'en' => 'Library'],    'href' => '/news'],
                    ['label' => ['ru' => 'Вакансии',    'uz' => "Ish o'rinlari", 'en' => 'Vacancies'], 'href' => '/news'],
                ],
            ],
        ];

        foreach ($columns as $columnData) {
            $links = $columnData['links'];
            unset($columnData['links']);

            $column = FooterColumn::create($columnData);

            foreach ($links as $position => $linkData) {
                $column->links()->create([...$linkData, 'position' => $position + 1]);
            }
        }
    }
}
