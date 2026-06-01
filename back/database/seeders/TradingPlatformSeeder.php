<?php

namespace Database\Seeders;

use App\Models\TradingPlatform;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TradingPlatformSeeder extends Seeder
{
    private string $base;

    public function run(): void
    {
        $this->base = rtrim(config('app.url'), '/');
        $this->seedLogos();

        TradingPlatform::truncate();

        $platforms = [
            // ── Государственные ────────────────────────────────────────
            [
                'name'        => 'hayotbirja.uz',
                'subtitle'    => 'Основная государственная платформа для всех видов государственных закупок',
                'desc'        => 'Основная государственная платформа для всех видов государственных закупок. Предназначена для заказчиков и поставщиков по всей территории Узбекистана.',
                'url'         => 'https://hayotbirja.uz',
                'logo'        => $this->img('logos/hayotbirja.png'),
                'logo_color'  => '#fff',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Госзакупки', 'Обязательная', 'ЭЦП'],
                'sort_order'  => 1,
                'translations' => [
                    'uz' => [
                        'name'     => 'hayotbirja.uz',
                        'subtitle' => "Barcha turdagi davlat xaridlari uchun asosiy davlat platformasi",
                        'desc'     => "O'zbekiston bo'ylab barcha buyurtmachilar va yetkazib beruvchilar uchun mo'ljallangan davlat xaridlarining asosiy platformasi.",
                    ],
                    'en' => [
                        'name'     => 'hayotbirja.uz',
                        'subtitle' => 'Main state platform for all types of public procurement',
                        'desc'     => 'The main state platform for all types of public procurement, designed for customers and suppliers across Uzbekistan.',
                    ],
                ],
            ],
            [
                'name'        => 'xarid.uzex.uz',
                'subtitle'    => 'Биржевые торги и биржевые закупки — UzEx',
                'desc'        => 'Электронная биржа для проведения биржевых торгов, закупок топлива, металлов и сырьевых товаров. Площадка Узбекской республиканской товарно-сырьевой биржи.',
                'url'         => 'https://xarid.uzex.uz',
                'logo'        => null,
                'logo_color'  => '#059669',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Биржа', 'Топливо', 'Сырьё'],
                'sort_order'  => 2,
                'translations' => [
                    'uz' => [
                        'name'     => 'xarid.uzex.uz',
                        'subtitle' => "Birja savdolari va birja xaridlari — UzEx",
                        'desc'     => "Yoqilg'i, metallar va xom ashyo xaridlari uchun elektron birja. O'zbekiston respublika tovar-xom ashyo birjasi platformasi.",
                    ],
                    'en' => [
                        'name'     => 'xarid.uzex.uz',
                        'subtitle' => 'Exchange trading and exchange procurement — UzEx',
                        'desc'     => 'Electronic exchange for conducting exchange trading, procurement of fuel, metals and raw materials. Platform of the Uzbek Republican Commodity Exchange.',
                    ],
                ],
            ],
            [
                'name'        => 'tender-xarid.ebirja.uz/tender',
                'subtitle'    => 'Тендерные закупки товаров, работ и услуг',
                'desc'        => 'Специализированная электронная площадка для проведения тендерных процедур государственными организациями и предприятиями с государственным участием.',
                'url'         => 'https://tender-xarid.ebirja.uz/tender',
                'logo'        => null,
                'logo_color'  => '#7c3aed',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'Медицина', 'Минздрав'],
                'sort_order'  => 3,
                'translations' => [
                    'uz' => [
                        'name'     => 'tender-xarid.ebirja.uz/tender',
                        'subtitle' => "Tovar, ish va xizmatlar tender xaridlari",
                        'desc'     => "Davlat tashkilotlari va davlat ishtirokidagi korxonalar tomonidan tender tartib-taomillarini o'tkazish uchun ixtisoslashgan elektron maydon.",
                    ],
                    'en' => [
                        'name'     => 'tender-xarid.ebirja.uz/tender',
                        'subtitle' => 'Tender procurement of goods, works and services',
                        'desc'     => 'Specialised electronic platform for conducting tender procedures by state organisations and enterprises with state participation.',
                    ],
                ],
            ],
            [
                'name'        => 'farma.xarid.uz',
                'subtitle'    => 'Закупки фармацевтической продукции и медоборудования',
                'desc'        => 'Специализированная государственная платформа для государственных закупок лекарственных средств, медицинских изделий и оборудования для учреждений здравоохранения.',
                'url'         => 'https://farma.xarid.uz',
                'logo'        => null,
                'logo_color'  => '#7c3aed',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'Медицина', 'Минздрав'],
                'sort_order'  => 4,
                'translations' => [
                    'uz' => [
                        'name'     => 'farma.xarid.uz',
                        'subtitle' => "Farmatsevtika mahsulotlari va tibbiy uskunalar xaridlari",
                        'desc'     => "Sog'liqni saqlash muassasalari uchun dori vositalari, tibbiy buyumlar va uskunalarni davlat xaridlari uchun ixtisoslashgan davlat platformasi.",
                    ],
                    'en' => [
                        'name'     => 'farma.xarid.uz',
                        'subtitle' => 'Procurement of pharmaceutical products and medical equipment',
                        'desc'     => 'Specialised state platform for state procurement of medicines, medical devices and equipment for healthcare institutions.',
                    ],
                ],
            ],
            [
                'name'        => 'agro.uzex.uz/home',
                'subtitle'    => 'Закупки сельскохозяйственной продукции',
                'desc'        => 'Электронная торговая площадка для проведения закупок сельскохозяйственной продукции, сырья и товаров агропромышленного комплекса.',
                'url'         => 'https://agro.uzex.uz/home',
                'logo'        => null,
                'logo_color'  => '#16a34a',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'Медицина', 'Минздрав'],
                'sort_order'  => 5,
                'translations' => [
                    'uz' => [
                        'name'     => 'agro.uzex.uz/home',
                        'subtitle' => "Qishloq xo'jaligi mahsulotlari xaridlari",
                        'desc'     => "Qishloq xo'jaligi mahsulotlari, xom ashyo va agrosanoat kompleksi tovarlarini sotib olish uchun elektron savdo maydoni.",
                    ],
                    'en' => [
                        'name'     => 'agro.uzex.uz/home',
                        'subtitle' => 'Procurement of agricultural products',
                        'desc'     => 'Electronic trading platform for procurement of agricultural products, raw materials and agro-industrial complex goods.',
                    ],
                ],
            ],
            [
                'name'        => 'ekoplatforma.uz/home',
                'subtitle'    => 'Закупки в сфере экологии и природопользования',
                'desc'        => 'Специализированная платформа для организации закупок товаров, работ и услуг в области экологии, охраны окружающей среды и природных ресурсов.',
                'url'         => 'https://ekoplatforma.uz/home',
                'logo'        => null,
                'logo_color'  => '#15803d',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'Медицина', 'Минздрав'],
                'sort_order'  => 6,
                'translations' => [
                    'uz' => [
                        'name'     => 'ekoplatforma.uz/home',
                        'subtitle' => "Ekologiya va tabiatdan foydalanish sohasidagi xaridlar",
                        'desc'     => "Ekologiya, atrof-muhitni muhofaza qilish va tabiiy resurslar sohasidagi tovar, ish va xizmatlarni sotib olishni tashkil etish uchun ixtisoslashgan platforma.",
                    ],
                    'en' => [
                        'name'     => 'ekoplatforma.uz/home',
                        'subtitle' => 'Procurement in the field of ecology and nature management',
                        'desc'     => 'Specialised platform for organising procurement of goods, works and services in the field of ecology, environmental protection and natural resources.',
                    ],
                ],
            ],
            [
                'name'        => 'cooperation.uz',
                'subtitle'    => 'Кооперационные закупки и промышленная кооперация',
                'desc'        => 'Площадка для взаимодействия производителей, поставщиков и заказчиков с целью развития промышленной кооперации и локализации производства.',
                'url'         => 'https://new.cooperation.uz',
                'logo'        => 'https://new.cooperation.uz/images/new.cooperation.png',
                'logo_color'  => '#d97706',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'Медицина', 'Минздрав'],
                'sort_order'  => 7,
                'translations' => [
                    'uz' => [
                        'name'     => 'cooperation.uz',
                        'subtitle' => "Kooperatsion xaridlar va sanoat kooperatsiyasi",
                        'desc'     => "Sanoat kooperatsiyasini rivojlantirish va ishlab chiqarishni lokalizatsiya qilish maqsadida ishlab chiqaruvchilar, yetkazib beruvchilar va buyurtmachilarning o'zaro hamkorligi uchun maydon.",
                    ],
                    'en' => [
                        'name'     => 'cooperation.uz',
                        'subtitle' => 'Cooperation procurement and industrial cooperation',
                        'desc'     => 'Platform for interaction of manufacturers, suppliers and customers to develop industrial cooperation and localise production.',
                    ],
                ],
            ],
            [
                'name'        => 'tender.mc.uz',
                'subtitle'    => 'Закупки для организаций здравоохранения',
                'desc'        => 'Электронная платформа для проведения закупок товаров, работ и услуг для медицинских учреждений и организаций системы здравоохранения.',
                'url'         => 'https://tender.mc.uz',
                'logo'        => null,
                'logo_color'  => '#b45309',
                'category'    => 'government',
                'is_official' => true,
                'tags'        => ['Фармация', 'Медицина', 'Минздрав'],
                'sort_order'  => 8,
                'translations' => [
                    'uz' => [
                        'name'     => 'tender.mc.uz',
                        'subtitle' => "Sog'liqni saqlash tashkilotlari uchun xaridlar",
                        'desc'     => "Tibbiy muassasalar va sog'liqni saqlash tizimi tashkilotlari uchun tovar, ish va xizmatlarni sotib olish uchun elektron platforma.",
                    ],
                    'en' => [
                        'name'     => 'tender.mc.uz',
                        'subtitle' => 'Procurement for healthcare organisations',
                        'desc'     => 'Electronic platform for procurement of goods, works and services for medical institutions and healthcare system organisations.',
                    ],
                ],
            ],

            // ── Корпоративные ──────────────────────────────────────────
            [
                'name'        => 'Tendergpt',
                'subtitle'    => 'Корпоративная закупочная платформа Tendergpt',
                'desc'        => 'Современная B2B-платформа для автоматизации корпоративных закупок, поиска поставщиков и проведения закупочных процедур для бизнеса любого масштаба.',
                'url'         => 'https://tendergpt.uz',
                'logo'        => $this->img('logos/tendergpt.png'),
                'logo_color'  => '#E1E1E1',
                'category'    => 'corporate',
                'is_official' => false,
                'tags'        => ['Корпоративные', 'B2B'],
                'sort_order'  => 10,
                'translations' => [
                    'uz' => [
                        'name'     => 'Tendergpt',
                        'subtitle' => "Tendergpt korporativ xarid platformasi",
                        'desc'     => "Har qanday o'lchamdagi biznes uchun korporativ xaridlarni avtomatlashtirish, yetkazib beruvchilarni qidirish va xarid tartib-taomillarini o'tkazish uchun zamonaviy B2B-platforma.",
                    ],
                    'en' => [
                        'name'     => 'Tendergpt',
                        'subtitle' => 'Tendergpt corporate procurement platform',
                        'desc'     => 'Modern B2B platform for automating corporate procurement, finding suppliers and conducting procurement procedures for businesses of any size.',
                    ],
                ],
            ],
            [
                'name'        => 'Uzum',
                'subtitle'    => 'Корпоративная закупочная платформа Uzum',
                'desc'        => 'Платформа для проведения корпоративных закупок товаров и услуг, обеспечивающая удобное взаимодействие между заказчиками и поставщиками по всему Узбекистану.',
                'url'         => 'https://b2buz.uz/',
                'logo'        => $this->img('logos/uzum.png'),
                'logo_color'  => '#fff',
                'category'    => 'corporate',
                'is_official' => false,
                'tags'        => ['Корпоративные', 'B2B'],
                'sort_order'  => 11,
                'translations' => [
                    'uz' => [
                        'name'     => 'Uzum',
                        'subtitle' => "Uzum korporativ xarid platformasi",
                        'desc'     => "Butun O'zbekiston bo'ylab buyurtmachilar va yetkazib beruvchilar o'rtasida qulay o'zaro aloqani ta'minlovchi tovar va xizmatlarni korporativ xaridlari platformasi.",
                    ],
                    'en' => [
                        'name'     => 'Uzum',
                        'subtitle' => 'Uzum corporate procurement platform',
                        'desc'     => 'Platform for corporate procurement of goods and services, providing convenient interaction between customers and suppliers across Uzbekistan.',
                    ],
                ],
            ],
            [
                'name'        => 'Bnect',
                'subtitle'    => 'Корпоративная закупочная платформа Bnect',
                'desc'        => 'B2B-маркетплейс для корпоративных закупок, позволяющий компаниям находить поставщиков, сравнивать предложения и эффективно управлять закупочной деятельностью.',
                'url'         => 'https://bnect.pro',
                'logo'        => null,
                'logo_color'  => '#0e7490',
                'category'    => 'corporate',
                'is_official' => false,
                'tags'        => ['Корпоративные', 'B2B', 'Маркетплейс'],
                'sort_order'  => 12,
                'translations' => [
                    'uz' => [
                        'name'     => 'Bnect',
                        'subtitle' => "Bnect korporativ xarid platformasi",
                        'desc'     => "Kompaniyalarga yetkazib beruvchilarni topish, takliflarni solishtirishga va xarid faoliyatini samarali boshqarishga imkon beruvchi korporativ xaridlar uchun B2B-bozor.",
                    ],
                    'en' => [
                        'name'     => 'Bnect',
                        'subtitle' => 'Bnect corporate procurement platform',
                        'desc'     => 'B2B marketplace for corporate procurement, allowing companies to find suppliers, compare offers and effectively manage procurement activities.',
                    ],
                ],
            ],
            [
                'name'        => 'UzAuto Tender',
                'subtitle'    => 'Тендерный портал UzAuto Motors',
                'desc'        => 'Корпоративная закупочная платформа крупнейшего автопроизводителя Узбекистана для проведения тендеров и отбора поставщиков комплектующих, материалов, оборудования и услуг.',
                'url'         => 'https://uzautomotors.com',
                'logo'        => null,
                'logo_color'  => '#dc2626',
                'category'    => 'corporate',
                'is_official' => false,
                'tags'        => ['Автопром', 'Компоненты'],
                'sort_order'  => 13,
                'translations' => [
                    'uz' => [
                        'name'     => 'UzAuto Tender',
                        'subtitle' => "UzAuto Motors tender portali",
                        'desc'     => "O'zbekistonning yirik avtomobil ishlab chiqaruvchisining komponentlar, materiallar, uskunalar va xizmatlar yetkazib beruvchilarini tanlash uchun korporativ xarid platformasi.",
                    ],
                    'en' => [
                        'name'     => 'UzAuto Tender',
                        'subtitle' => 'UzAuto Motors tender portal',
                        'desc'     => "Corporate procurement platform of Uzbekistan's largest car manufacturer for conducting tenders and selecting suppliers of components, materials, equipment and services.",
                    ],
                ],
            ],
            [
                'name'        => 'B2biz',
                'subtitle'    => 'B2B-платформа для корпоративных закупок',
                'desc'        => 'Электронная площадка для взаимодействия бизнеса и поставщиков, предназначенная для организации закупок товаров, работ и услуг в корпоративном секторе.',
                'url'         => 'https://b2biz.uz',
                'logo'        => null,
                'logo_color'  => '#0e7490',
                'category'    => 'corporate',
                'is_official' => false,
                'tags'        => ['Корпоративные', 'B2B', 'Маркетплейс'],
                'sort_order'  => 14,
                'translations' => [
                    'uz' => [
                        'name'     => 'B2biz',
                        'subtitle' => "Korporativ xaridlar uchun B2B-platforma",
                        'desc'     => "Korporativ sektorda tovar, ish va xizmatlar xaridlarini tashkil etish uchun mo'ljallangan biznes va yetkazib beruvchilar o'rtasidagi o'zaro aloqa uchun elektron maydon.",
                    ],
                    'en' => [
                        'name'     => 'B2biz',
                        'subtitle' => 'B2B platform for corporate procurement',
                        'desc'     => 'Electronic platform for business and supplier interaction, designed for organising procurement of goods, works and services in the corporate sector.',
                    ],
                ],
            ],

            // ── Агрегаторы ─────────────────────────────────────────────
            [
                'name'        => 'TenderZone',
                'subtitle'    => 'Агрегатор государственных и корпоративных тендеров',
                'desc'        => 'Крупнейший агрегатор всех государственных и корпоративных тендеров Узбекистана. AI-анализ, уведомления в Telegram, аналитика конкурентов. Члены АУГЗ — скидка 30%.',
                'url'         => 'https://tenderzone.uz',
                'logo'        => $this->img('logos/tenderzone.png'),
                'logo_color'  => '#8E8E8E',
                'category'    => 'aggregator',
                'is_official' => false,
                'tags'        => ['100 000+ Тендеров'],
                'sort_order'  => 20,
                'translations' => [
                    'uz' => [
                        'name'     => 'TenderZone',
                        'subtitle' => "Davlat va korporativ tenderlar agregatori",
                        'desc'     => "O'zbekistonning barcha davlat va korporativ tenderlarining eng yirik agregatori. AI-tahlil, Telegram bildirishnomalari, raqobatchilar tahlili. AUGZ a'zolari uchun 30% chegirma.",
                    ],
                    'en' => [
                        'name'     => 'TenderZone',
                        'subtitle' => 'Aggregator of state and corporate tenders',
                        'desc'     => "Uzbekistan's largest aggregator of all state and corporate tenders. AI analysis, Telegram notifications, competitor analytics. AUGZ members get 30% discount.",
                    ],
                ],
            ],
        ];

        foreach ($platforms as $data) {
            TradingPlatform::create($data);
        }
    }

    private function seedLogos(): void
    {
        $src = resource_path('logos');
        if (!is_dir($src)) return;

        Storage::disk('public')->makeDirectory('logos');

        foreach (glob("{$src}/*.{png,jpg,jpeg,svg,webp}", GLOB_BRACE) as $file) {
            $name = basename($file);
            if (!Storage::disk('public')->exists("logos/{$name}")) {
                Storage::disk('public')->put("logos/{$name}", file_get_contents($file));
            }
        }
    }

    private function img(string $path): string
    {
        return "{$this->base}/storage/{$path}";
    }
}
