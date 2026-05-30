<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'sort_order' => 1,
                'slug'       => 'basic',
                'label'      => 'Базовый',
                'price'      => null,
                'currency'   => null,
                'period'     => 'навсегда',
                'is_popular' => false,
                'cta_text'   => 'Зарегистрироваться',
                'features'   => [
                    ['text' => 'Доступ к новостям АУГЗ',       'included' => true],
                    ['text' => 'Открытые мероприятия',          'included' => true],
                    ['text' => 'Базовая информация о тендерах', 'included' => true],
                    ['text' => 'Закрытая аналитика',            'included' => false],
                    ['text' => 'Тендерные уведомления',         'included' => false],
                    ['text' => 'Скидки на обучение',            'included' => false],
                ],
                'translations' => [
                    'uz' => [
                        'label'    => 'Asosiy',
                        'period'   => 'abadiy',
                        'cta_text' => "Ro'yxatdan o'tish",
                        'features' => [
                            ['text' => "AUGZ yangiliklarga kirish",          'included' => true],
                            ['text' => 'Ochiq tadbirlar',                    'included' => true],
                            ['text' => "Tenderlar haqida asosiy ma'lumot",   'included' => true],
                            ['text' => 'Yopiq tahlillar',                    'included' => false],
                            ['text' => 'Tender bildirishnomalari',           'included' => false],
                            ['text' => "Ta'limda chegirmalar",               'included' => false],
                        ],
                    ],
                    'en' => [
                        'label'    => 'Basic',
                        'period'   => 'forever',
                        'cta_text' => 'Register',
                        'features' => [
                            ['text' => 'Access to AUGZ news',         'included' => true],
                            ['text' => 'Open events',                  'included' => true],
                            ['text' => 'Basic tender information',     'included' => true],
                            ['text' => 'Closed analytics',             'included' => false],
                            ['text' => 'Tender notifications',         'included' => false],
                            ['text' => 'Training discounts',           'included' => false],
                        ],
                    ],
                ],
            ],
            [
                'sort_order' => 2,
                'slug'       => 'pro',
                'label'      => 'Профессиональный',
                'price'      => '1 200 000',
                'currency'   => 'сум',
                'period'     => 'в год',
                'is_popular' => true,
                'cta_text'   => 'Вступить сейчас',
                'features'   => [
                    ['text' => 'Всё из базового',          'included' => true],
                    ['text' => 'Закрытая аналитика рынка', 'included' => true],
                    ['text' => 'Тендерные уведомления',    'included' => true],
                    ['text' => 'Скидка 30% на обучение',   'included' => true],
                    ['text' => 'Сертификат члена АУГЗ',    'included' => true],
                    ['text' => 'Персональный менеджер',    'included' => false],
                ],
                'translations' => [
                    'uz' => [
                        'label'    => 'Professional',
                        'currency' => 'so\'m',
                        'period'   => 'yilda',
                        'cta_text' => "Hozir qo'shiling",
                        'features' => [
                            ['text' => "Asosiydan hammasi",              'included' => true],
                            ['text' => 'Yopiq bozor tahlili',            'included' => true],
                            ['text' => 'Tender bildirishnomalari',        'included' => true],
                            ['text' => "Ta'limda 30% chegirma",          'included' => true],
                            ['text' => "AUGZ a'zosi sertifikati",        'included' => true],
                            ['text' => 'Shaxsiy menejer',                'included' => false],
                        ],
                    ],
                    'en' => [
                        'label'    => 'Professional',
                        'currency' => 'UZS',
                        'period'   => 'per year',
                        'cta_text' => 'Join now',
                        'features' => [
                            ['text' => 'Everything in Basic',      'included' => true],
                            ['text' => 'Closed market analytics',  'included' => true],
                            ['text' => 'Tender notifications',     'included' => true],
                            ['text' => '30% training discount',    'included' => true],
                            ['text' => 'AUGZ member certificate',  'included' => true],
                            ['text' => 'Personal manager',         'included' => false],
                        ],
                    ],
                ],
            ],
            [
                'sort_order' => 3,
                'slug'       => 'corporate',
                'label'      => 'Корпоративный',
                'price'      => null,
                'currency'   => null,
                'period'     => 'индивидуально',
                'is_popular' => false,
                'cta_text'   => 'Связаться с нами',
                'features'   => [
                    ['text' => 'Всё из профессионального',       'included' => true],
                    ['text' => 'Персональный менеджер',          'included' => true],
                    ['text' => 'Корпоративное обучение команды', 'included' => true],
                    ['text' => 'Логотип на сайте АУГЗ',          'included' => true],
                    ['text' => 'Приоритет на мероприятиях',      'included' => true],
                    ['text' => 'Эксклюзивные партнёрства',       'included' => true],
                ],
                'translations' => [
                    'uz' => [
                        'label'    => 'Korporativ',
                        'period'   => 'individual',
                        'cta_text' => 'Biz bilan bog\'laning',
                        'features' => [
                            ['text' => "Professionaldan hammasi",         'included' => true],
                            ['text' => 'Shaxsiy menejer',                 'included' => true],
                            ['text' => "Jamoa uchun korporativ ta'lim",   'included' => true],
                            ['text' => "AUGZ saytida logotip",            'included' => true],
                            ['text' => 'Tadbirlarda ustuvorlik',          'included' => true],
                            ['text' => 'Eksklyuziv hamkorliklar',         'included' => true],
                        ],
                    ],
                    'en' => [
                        'label'    => 'Corporate',
                        'period'   => 'individual',
                        'cta_text' => 'Contact us',
                        'features' => [
                            ['text' => 'Everything in Professional',  'included' => true],
                            ['text' => 'Personal manager',            'included' => true],
                            ['text' => 'Corporate team training',     'included' => true],
                            ['text' => 'Logo on AUGZ website',        'included' => true],
                            ['text' => 'Priority at events',          'included' => true],
                            ['text' => 'Exclusive partnerships',      'included' => true],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($plans as $data) {
            MembershipPlan::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
