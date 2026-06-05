<?php

namespace Database\Seeders;

use App\Models\NavbarLink;
use Illuminate\Database\Seeder;

class NavbarSeeder extends Seeder
{
    public function run(): void
    {
        NavbarLink::truncate();

        $links = [
            [
                'label' => ['ru' => 'О нас', 'uz' => 'Biz haqimizda', 'en' => 'About'],
                'href'  => '/about',
                'position' => 1,
            ],
            [
                'label' => ['ru' => 'Новости', 'uz' => 'Yangiliklar', 'en' => 'News'],
                'href'  => '/news',
                'position' => 2,
            ],
            [
                'label' => ['ru' => 'Услуги', 'uz' => 'Xizmatlar', 'en' => 'Services'],
                'href'  => '/services',
                'position' => 3,
            ],
            [
                'label' => ['ru' => 'Торговые площадки', 'uz' => 'Tijorat platformalari', 'en' => 'Trading platforms'],
                'href'  => '/markets',
                'position' => 4,
            ],
            [
                'label' => ['ru' => 'Членство', 'uz' => "A'zolik", 'en' => 'Membership'],
                'href'  => '/membership',
                'position' => 5,
            ],
            [
                'label' => ['ru' => 'Нормативные документы', 'uz' => 'Normativ hujjatlar', 'en' => 'Regulatory documents'],
                'href'  => '/regulations',
                'position' => 6,
            ],
            [
                'label' => ['ru' => 'Контакты', 'uz' => 'Aloqa', 'en' => 'Contacts'],
                'href'  => '/contacts',
                'position' => 7,
            ],
        ];

        foreach ($links as $link) {
            NavbarLink::create($link);
        }
    }
}
