<?php

namespace Database\Seeders;

use App\Models\TradingPlatform;
use Illuminate\Database\Seeder;

class TradingPlatformSeeder extends Seeder
{
    public function run(): void
    {
        TradingPlatform::truncate();

        $platforms = [
            [
                'name'        => 'hayotbirja.uz',
                'subtitle'    => 'Единая электронная торговая площадка (xt-xarid)',
                'desc'        => 'Основная государственная платформа Узбекистана для проведения электронных торгов и государственных закупок. Охватывает все виды тендеров для государственных заказчиков и поставщиков.',
                'url'         => 'https://hayotbirja.uz',
                'logo'        => 'https://hayotbirja.uz/img/logotype.svg',
                'logo_color'  => '#1a56db',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Госзакупки', 'xt-xarid', 'Тендеры'],
                'sort_order'  => 1,
                'translations' => [
                    'uz' => [
                        'name'     => 'hayotbirja.uz',
                        'subtitle' => 'Yagona elektron savdo platformasi (xt-xarid)',
                        'desc'     => "O'zbekistonning davlat xaridlari va elektron savdolarini o'tkazish uchun asosiy davlat platformasi.",
                    ],
                    'en' => [
                        'name'     => 'hayotbirja.uz',
                        'subtitle' => 'Unified electronic trading platform (xt-xarid)',
                        'desc'     => 'The main state platform of Uzbekistan for conducting electronic trading and public procurement.',
                    ],
                ],
            ],
            [
                'name'        => 'xarid.uzex.uz',
                'subtitle'    => 'Давлат харидлари махсус ахборот портали',
                'desc'        => 'Специальный информационный портал государственных закупок Узбекской республиканской товарно-сырьевой биржи (UzEx). Проведение биржевых торгов по сырьевым товарам, топливу и металлам.',
                'url'         => 'https://xarid.uzex.uz',
                'logo'        => null,
                'logo_color'  => '#059669',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['UzEx', 'Биржа', 'Сырьё', 'Топливо'],
                'sort_order'  => 2,
                'translations' => [
                    'uz' => [
                        'name'     => 'xarid.uzex.uz',
                        'subtitle' => "Davlat xaridlari maxsus axborot portali",
                        'desc'     => "UzEx tovar-xom ashyo birjasining davlat xaridlari bo'yicha maxsus axborot portali.",
                    ],
                    'en' => [
                        'name'     => 'xarid.uzex.uz',
                        'subtitle' => 'State Procurement Special Information Portal',
                        'desc'     => 'Special information portal for state procurement of the Uzbek Republican Commodity Exchange (UzEx).',
                    ],
                ],
            ],
            [
                'name'        => 'tender-xarid.ebirja.uz',
                'subtitle'    => 'Электронная биржа — тендерные закупки',
                'desc'        => 'Платформа электронной биржи Узбекистана для проведения тендерных закупок. Организует торги по широкому спектру товаров, работ и услуг в электронном формате.',
                'url'         => 'https://tender-xarid.ebirja.uz/tender',
                'logo'        => null,
                'logo_color'  => '#0f172a',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['eBirja', 'Тендеры', 'Электронные торги'],
                'sort_order'  => 3,
                'translations' => [
                    'uz' => [
                        'name'     => 'tender-xarid.ebirja.uz',
                        'subtitle' => "Elektron birja — tender xaridlari",
                        'desc'     => "O'zbekiston elektron birjasining tender xaridlarini o'tkazish platformasi.",
                    ],
                    'en' => [
                        'name'     => 'tender-xarid.ebirja.uz',
                        'subtitle' => 'Electronic exchange — tender procurement',
                        'desc'     => "Uzbekistan's electronic exchange platform for conducting tender procurement.",
                    ],
                ],
            ],
            [
                'name'        => 'farma.uzex.uz',
                'subtitle'    => 'Закупки фармацевтической продукции — UzEx Farma',
                'desc'        => 'Специализированная площадка UzEx для государственных и корпоративных закупок лекарственных средств, медицинских изделий и фармацевтического сырья.',
                'url'         => 'https://farma.uzex.uz/home',
                'logo'        => 'https://farma.uzex.uz/assets/images/blue-logo.svg',
                'logo_color'  => '#7c3aed',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'UzEx', 'Медицина', 'Минздрав'],
                'sort_order'  => 4,
                'translations' => [
                    'uz' => [
                        'name'     => 'farma.uzex.uz',
                        'subtitle' => "Farmatsevtika mahsulotlari xaridlari — UzEx Farma",
                        'desc'     => "Dori vositalari, tibbiy buyumlar va farmatsevtika xom ashyosini davlat va korporativ xaridlari uchun UzEx ixtisoslashgan platformasi.",
                    ],
                    'en' => [
                        'name'     => 'farma.uzex.uz',
                        'subtitle' => 'Pharmaceutical procurement — UzEx Farma',
                        'desc'     => 'Specialized UzEx platform for state and corporate procurement of medicines, medical devices and pharmaceutical raw materials.',
                    ],
                ],
            ],
            [
                'name'        => 'agro.uzex.uz',
                'subtitle'    => 'Агропромышленные закупки — UzEx Agro',
                'desc'        => 'Площадка UzEx для торгов и закупок в агропромышленном секторе: сельскохозяйственная продукция, зерно, хлопок, удобрения и сельхозтехника.',
                'url'         => 'https://agro.uzex.uz/home',
                'logo'        => null,
                'logo_color'  => '#16a34a',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Агро', 'UzEx', 'Сельхоз', 'Зерно'],
                'sort_order'  => 5,
                'translations' => [
                    'uz' => [
                        'name'     => 'agro.uzex.uz',
                        'subtitle' => "Agrosanoat xaridlari — UzEx Agro",
                        'desc'     => "Qishloq xo'jaligi mahsulotlari, g'alla, paxta, o'g'it va qishloq xo'jaligi texnikasi savdolari uchun UzEx agrosanoat platformasi.",
                    ],
                    'en' => [
                        'name'     => 'agro.uzex.uz',
                        'subtitle' => 'Agro-industrial procurement — UzEx Agro',
                        'desc'     => 'UzEx agro-industrial platform for trading and procurement of agricultural products, grain, cotton, fertilizers and agricultural machinery.',
                    ],
                ],
            ],
            [
                'name'        => 'ekoplatforma.uz',
                'subtitle'    => 'Экосистема местных производителей Узбекистана',
                'desc'        => 'Государственная платформа «Маҳаллий ишлаб чиқарувчилар экотизими» — маркетплейс для поддержки и продвижения продукции отечественных производителей на внутреннем и внешнем рынке.',
                'url'         => 'https://ekoplatforma.uz/home',
                'logo'        => null,
                'logo_color'  => '#15803d',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Местный товар', 'Экосистема', 'Производители'],
                'sort_order'  => 6,
                'translations' => [
                    'uz' => [
                        'name'     => 'ekoplatforma.uz',
                        'subtitle' => "Mahalliy ishlab chiqaruvchilar ekotizimi",
                        'desc'     => "Mahalliy ishlab chiqaruvchilar mahsulotlarini ichki va tashqi bozorda qo'llab-quvvatlash va targ'ib qilish uchun davlat platformasi.",
                    ],
                    'en' => [
                        'name'     => 'ekoplatforma.uz',
                        'subtitle' => 'Ecosystem of local manufacturers of Uzbekistan',
                        'desc'     => 'State platform for supporting and promoting products of domestic manufacturers in the domestic and foreign markets.',
                    ],
                ],
            ],
            [
                'name'        => 'cooperation.uz',
                'subtitle'    => 'Электронный портал кооперации Узбекистана',
                'desc'        => 'Государственный B2B-портал кооперации и промышленной кооперации. Связывает заказчиков и поставщиков промышленных товаров отечественного производства. Приоритет для местных производителей.',
                'url'         => 'https://new.cooperation.uz',
                'logo'        => 'https://new.cooperation.uz/images/new.cooperation.png',
                'logo_color'  => '#d97706',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Кооперация', 'B2B', 'Местный товар', 'Промышленность'],
                'sort_order'  => 7,
                'translations' => [
                    'uz' => [
                        'name'     => 'cooperation.uz',
                        'subtitle' => "O'zbekiston elektron kooperatsiya portali",
                        'desc'     => "Mahalliy ishlab chiqarish sanoat tovarlari bo'yicha buyurtmachilar va yetkazib beruvchilarni bog'lovchi davlat B2B kooperatsiya portali.",
                    ],
                    'en' => [
                        'name'     => 'cooperation.uz',
                        'subtitle' => 'Electronic cooperation portal of Uzbekistan',
                        'desc'     => 'State B2B cooperation portal connecting buyers and suppliers of domestically produced industrial goods.',
                    ],
                ],
            ],
            [
                'name'        => 'TenderZone',
                'subtitle'    => 'Агрегатор тендеров — платформа АУГЗ',
                'desc'        => 'Собственная платформа Ассоциации для мониторинга и поиска тендеров по всем площадкам Узбекистана в одном месте. Уведомления, аналитика и сопровождение участника.',
                'url'         => 'https://tenderzone.uz',
                'logo'        => null,
                'logo_color'  => '#D1832C',
                'category'    => 'aggregator',
                'is_official' => false,
                'tags'        => ['Мониторинг', 'Агрегатор', 'АУГЗ'],
                'sort_order'  => 9,
                'translations' => [
                    'uz' => [
                        'name'     => 'TenderZone',
                        'subtitle' => "Tenderlar agregatori — AUGZ platformasi",
                        'desc'     => "Bir joyda O'zbekistonning barcha platformalari bo'yicha tenderlarni monitoring qilish va qidirish uchun assotsiatsiya platformasi.",
                    ],
                    'en' => [
                        'name'     => 'TenderZone',
                        'subtitle' => 'Tender aggregator — AUGZ platform',
                        'desc'     => "The Association's own platform for monitoring and searching tenders across all Uzbekistan platforms in one place.",
                    ],
                ],
            ],
            [
                'name'        => 'tender.mc.uz',
                'subtitle'    => 'Электронная тендерная система Министерства строительства',
                'desc'        => 'Официальная платформа Министерства строительства Республики Узбекистан для проведения электронных тендеров в сфере строительства, проектирования и ремонтно-строительных работ.',
                'url'         => 'https://tender.mc.uz',
                'logo'        => null,
                'logo_color'  => '#b45309',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Строительство', 'Минстрой', 'Тендеры'],
                'sort_order'  => 8,
                'translations' => [
                    'uz' => [
                        'name'     => 'tender.mc.uz',
                        'subtitle' => "Qurilish vazirligi elektron tender tizimi",
                        'desc'     => "O'zbekiston Respublikasi Qurilish vazirligi qurilish, loyihalash va ta'mirlash ishlari bo'yicha elektron tenderlar o'tkazish uchun rasmiy platformasi.",
                    ],
                    'en' => [
                        'name'     => 'tender.mc.uz',
                        'subtitle' => 'Electronic tender system of the Ministry of Construction',
                        'desc'     => 'Official platform of the Ministry of Construction of Uzbekistan for conducting electronic tenders in construction, design and repair works.',
                    ],
                ],
            ],
        ];

        foreach ($platforms as $data) {
            TradingPlatform::create($data);
        }
    }
}
