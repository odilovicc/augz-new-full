<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PageSeeder extends Seeder
{
    private string $base;

    public function run(): void
    {
        $this->base = rtrim(config('app.url'), '/');

        $this->seedLogos();

        $pages = [
            'home'       => $this->homeContent(),
            'about'      => $this->aboutContent(),
            'news'       => $this->newsContent(),
            'services'   => $this->servicesContent(),
            'membership' => $this->membershipContent(),
            'markets'    => $this->marketsContent(),
            'contacts'   => $this->contactsContent(),
            'report'     => $this->reportContent(),
            'tenderzone'  => $this->tenderzoneContent(),
            'regulations' => $this->regulationsContent(),
        ];

        foreach ($pages as $slug => $content) {
            Page::updateOrCreate(['slug' => $slug], ['content' => $content]);
        }
    }

    private function img(string $path): string
    {
        return "{$this->base}/storage/{$path}";
    }

    private function seedLogos(): void
    {
        $src = resource_path('logos');
        if (!is_dir($src)) {
            return;
        }

        Storage::disk('public')->makeDirectory('logos');

        foreach (glob("{$src}/*.{png,jpg,jpeg,svg,webp}", GLOB_BRACE) as $file) {
            $name = basename($file);
            if (!Storage::disk('public')->exists("logos/{$name}")) {
                Storage::disk('public')->put("logos/{$name}", file_get_contents($file));
            }
        }
    }

    private function homeContent(): array
    {
        return [
            'hero' => [
                'image'   => $this->img('pages/Hero.png'),
                'title_1' => ['ru' => 'Мы создаём',            'uz' => 'Biz yaratamiz',    'en' => 'We create'],
                'title_2' => ['ru' => 'прозрачные закупки',    'uz' => 'shaffof xaridlar', 'en' => 'transparent procurement'],
                'title_3' => ['ru' => 'и честную конкуренцию', 'uz' => 'va adolatli raqobat', 'en' => 'and fair competition'],
                'subtitle' => [
                    'ru' => 'Содействуем развитию системы государственных закупок и повышаем профессиональный уровень участников рынка Узбекистана.',
                    'uz' => "O'zbekiston bozori ishtirokchilarining professional darajasini oshirish va davlat xaridlari tizimini rivojlantirishga ko'maklashamiz.",
                    'en' => 'We promote the development of the public procurement system and raise the professional level of market participants in Uzbekistan.',
                ],
                'btn_primary'   => ['label' => ['ru' => 'О нас',       'uz' => 'Biz haqimizda', 'en' => 'About us'],      'href' => '/about'],
                'btn_secondary' => ['label' => ['ru' => 'Наши услуги', 'uz' => 'Xizmatlarimiz', 'en' => 'Our services'],  'href' => '/services'],
            ],

            'about' => [
                'heading'            => ['ru' => 'Наши направления',  'uz' => "Bizning yo'nalishlarimiz", 'en' => 'Our directions'],
                'all_services_label' => ['ru' => 'Все услуги',        'uz' => 'Barcha xizmatlar',         'en' => 'All services'],
                'features' => [
                    [
                        'icon'  => 'heroicons:shield-check',
                        'title' => ['ru' => 'Защита интересов участников',    'uz' => 'Ishtirokchilar manfaatlarini himoya qilish', 'en' => 'Protecting participant interests'],
                        'desc'  => ['ru' => 'Представляем и защищаем права бизнеса в сфере государственных закупок.', 'uz' => 'Davlat xaridlari sohasida biznes huquqlarini ifodalamiz va himoya qilamiz.', 'en' => 'We represent and protect business rights in public procurement.'],
                    ],
                    [
                        'icon'  => 'heroicons:academic-cap',
                        'title' => ['ru' => 'Обучение и экспертиза',          'uz' => "Ta'lim va ekspertiza",    'en' => 'Training and expertise'],
                        'desc'  => ['ru' => 'Повышаем квалификацию участников и делимся профессиональными знаниями.', 'uz' => "Ishtirokchilar malakasini oshiramiz va professional bilimlarni ulashamiz.", 'en' => 'We improve participant qualifications and share professional knowledge.'],
                    ],
                    [
                        'icon'  => 'heroicons:chat-bubble-left-right',
                        'title' => ['ru' => 'Сотрудничество и диалог',        'uz' => 'Hamkorlik va muloqot',   'en' => 'Collaboration and dialogue'],
                        'desc'  => ['ru' => 'Налаживаем диалог между бизнесом и государством для системных изменений.', 'uz' => "Tizimli o'zgarishlar uchun biznes va davlat o'rtasida muloqot o'rnatamiz.", 'en' => 'We establish dialogue between business and government for systemic change.'],
                    ],
                    [
                        'icon'  => 'heroicons:chart-bar-square',
                        'title' => ['ru' => 'Развитие и стандарты',           'uz' => 'Rivojlanish va standartlar', 'en' => 'Development and standards'],
                        'desc'  => ['ru' => 'Разрабатываем стандарты и лучшие практики для эффективных закупок.', 'uz' => 'Samarali xaridlar uchun standartlar va eng yaxshi amaliyotlarni ishlab chiqamiz.', 'en' => 'We develop standards and best practices for effective procurement.'],
                    ],
                ],
            ],

            'stats' => [
                'label'   => ['ru' => 'Цифры',           'uz' => 'Raqamlar',           'en' => 'Numbers'],
                'heading' => ['ru' => 'Наши достижения', 'uz' => 'Bizning yutuqlarimiz','en' => 'Our achievements'],
                'items'   => [
                    ['icon' => 'heroicons:user-group',    'value' => ['ru' => '200+',  'uz' => '200+',  'en' => '200+'],  'label' => ['ru' => 'Компаний-членов',           'uz' => "Kompaniya-a'zolar",       'en' => 'Member companies']],
                    ['icon' => 'heroicons:calendar-days', 'value' => ['ru' => '15+',   'uz' => '15+',   'en' => '15+'],   'label' => ['ru' => 'Лет на рынке',              'uz' => 'Yillik tajriba',           'en' => 'Years on the market']],
                    ['icon' => 'heroicons:briefcase',     'value' => ['ru' => '20+',   'uz' => '20+',   'en' => '20+'],   'label' => ['ru' => 'Направлений деятельности', 'uz' => "Faoliyat yo'nalishlari",  'en' => 'Activity directions']],
                    ['icon' => 'heroicons:academic-cap',  'value' => ['ru' => '3000+', 'uz' => '3000+', 'en' => '3000+'], 'label' => ['ru' => 'Обученных специалистов',    'uz' => 'Tayyorlangan mutaxassislar','en' => 'Trained specialists']],
                ],
            ],

            'partners' => [
                'heading' => ['ru' => 'Партнёры', 'uz' => 'Hamkorlar', 'en' => 'Partners'],
                'logos'   => [
                    ['src' => $this->img('logos/icpa.png'),           'alt' => 'ICPA'],
                    ['src' => $this->img('logos/anticorruption.png'), 'alt' => 'Агентство по противодействию коррупции'],
                    ['src' => $this->img('logos/antimonopoly.png'),   'alt' => 'Антимонопольный комитет'],
                    ['src' => $this->img('logos/brokers.png'),        'alt' => 'Brokers'],
                    ['src' => $this->img('logos/tenderzone.png'),     'alt' => 'TenderZone'],
                    ['src' => $this->img('logos/tendergpt.png'),      'alt' => 'TenderGPT'],
                ],
            ],

            'contacts' => [
                'label'         => ['ru' => 'Контакты',          'uz' => 'Aloqa',                  'en' => 'Contacts'],
                'heading'       => ['ru' => 'Свяжитесь с нами', 'uz' => "Biz bilan bog'laning",   'en' => 'Contact us'],
                'address_value' => ['ru' => 'г. Ташкент, Мирабадский район, ул. Нукуса, 69', 'uz' => "Toshkent sh., Mirobod tumani, Nukus ko'chasi, 69", 'en' => '69 Nukus St, Mirobod district, Tashkent'],
                'phone'         => '+998 55 503 12 21',
                'email'         => 'info@augz.uz',
            ],

            'footer' => [
                'tagline'     => ['ru' => 'Ассоциация участников государственных закупок', 'uz' => 'Davlat xaridlari ishtirokchilari uyushmasi', 'en' => 'Association of Public Procurement Participants'],
                'description' => ['ru' => 'Мы работаем для создания прозрачной, эффективной и конкурентной системы государственных закупок в Узбекистане.', 'uz' => "O'zbekistonda shaffof, samarali va raqobatbardosh davlat xaridlari tizimini yaratish uchun ishlayapmiz.", 'en' => 'We work to create a transparent, efficient and competitive public procurement system in Uzbekistan.'],
            ],
        ];
    }

    private function aboutContent(): array
    {
        return [
            'hero' => [
                'image'    => $this->img('pages/hero.png'),
                'heading'  => ['ru' => 'О НАС',            'uz' => 'BIZ HAQIMIZDA',    'en' => 'ABOUT US'],
                'subtitle' => [
                    'ru' => 'Ассоциация участников государственных закупок Узбекистана объединяет профессионалов и компании, работающие в сфере государственных и корпоративных закупок.',
                    'uz' => "O'zbekiston davlat xaridlari ishtirokchilari uyushmasi davlat va korporativ xaridlar sohasida faoliyat yurituvchi mutaxassislar va kompaniyalarni birlashtiradi.",
                    'en' => 'The Association of Public Procurement Participants of Uzbekistan unites professionals and companies working in the field of public and corporate procurement.',
                ],
                'btn_label' => ['ru' => 'Связаться с нами', 'uz' => "Biz bilan bog'laning", 'en' => 'Contact us'],
                'btn_href'  => '#contacts',
            ],

            'intro' => [
                'badge'     => ['ru' => 'С 2013 года', 'uz' => '2013 yildan', 'en' => 'Since 2013'],
                'heading'   => [
                    'ru' => 'АССОЦИАЦИЯ ПРОФЕССИОНАЛОВ В СФЕРЕ УСЛУГ',
                    'uz' => 'XIZMATLAR SOHASIDAGI PROFESSIONALLAR UYUSHMASI',
                    'en' => 'ASSOCIATION OF PROFESSIONALS IN SERVICES',
                ],
                'desc'      => [
                    'ru' => 'Развиваем профессиональное сообщество и создаём возможности для роста.',
                    'uz' => "Professional hamjamiyatni rivojlantiramiz va o'sish uchun imkoniyatlar yaratamiz.",
                    'en' => 'We develop the professional community and create opportunities for growth.',
                ],
                'btn_label' => ['ru' => 'Вступить в ассоциацию', 'uz' => "Uyushmaga qo'shilish", 'en' => 'Join the association'],
                'btn_href'  => '/membership',
                'stats'     => [
                    ['icon' => 'heroicons:users',         'value' => '200+',  'label' => ['ru' => 'членов ассоциации',   'uz' => "uyushma a'zolari",    'en' => 'association members'],   'accent_color' => '#1e40af'],
                    ['icon' => 'heroicons:academic-cap',  'value' => '3000+', 'label' => ['ru' => 'проведено обучений', 'uz' => "o'tkazilgan treninglar", 'en' => 'trainings held'],       'accent_color' => '#0e7490'],
                    ['icon' => 'heroicons:book-open',     'value' => '5',     'label' => ['ru' => 'учебных программ',   'uz' => "o'quv dasturlari",      'en' => 'training programs'],    'accent_color' => '#166534'],
                ],
            ],

            'mission' => [
                'label'   => ['ru' => 'Наша миссия',   'uz' => 'Bizning missiyamiz', 'en' => 'Our mission'],
                'heading' => [
                    'ru' => 'Развиваем профессиональное сообщество в сфере закупок',
                    'uz' => "Xaridlar sohasida professional hamjamiyatni rivojlantirmoqdamiz",
                    'en' => 'Developing a professional community in the field of procurement',
                ],
                'text' => [
                    'ru' => 'Мы содействуем повышению качества и прозрачности государственных закупок, эффективности и добросовестной конкуренции, поддерживаем внедрение современных цифровых решений и международных стандартов.',
                    'uz' => "Biz davlat xaridlarining sifati va shaffofligi, samaradorligi va vijdonli raqobatning oshirishiga ko'maklashamiz.",
                    'en' => 'We promote the improvement of quality and transparency of public procurement, efficiency and fair competition, support the implementation of modern digital solutions and international standards.',
                ],
                'location' => ['ru' => 'Ташкент, Узбекистан — с 2013 года', 'uz' => "Toshkent, O'zbekiston — 2013 yildan", 'en' => 'Tashkent, Uzbekistan — since 2013'],
                'stats' => [
                    ['icon' => 'i-lucide-calendar',  'value' => '2013',  'label' => ['ru' => 'Год основания',          'uz' => 'Tashkil etilgan yil',      'en' => 'Year founded']],
                    ['icon' => 'i-lucide-users',      'value' => '1000+', 'label' => ['ru' => 'Членов ассоциации',     'uz' => "Uyushma a'zolari",         'en' => 'Association members']],
                    ['icon' => 'i-lucide-briefcase',  'value' => '20+',   'label' => ['ru' => 'Реализованных проектов','uz' => 'Amalga oshirilgan loyihalar','en' => 'Completed projects']],
                    ['icon' => 'i-lucide-clock',      'value' => '10+',   'label' => ['ru' => 'Лет на рынке',          'uz' => 'Yillik tajriba',            'en' => 'Years on the market']],
                ],
            ],

            'values' => [
                'heading' => ['ru' => 'НАШИ ЦЕННОСТИ', 'uz' => 'BIZNING QADRIYATLARIMIZ', 'en' => 'OUR VALUES'],
                'items' => [
                    [
                        'icon'  => 'i-lucide-shield-check',
                        'title' => ['ru' => 'Профессионализм', 'uz' => 'Professionallik',  'en' => 'Professionalism'],
                        'desc'  => ['ru' => 'Высокий стандарт услуг, экспертиза и ответственный подход в каждом проекте.', 'uz' => "Har bir loyihada yuqori xizmat standarti, ekspertiza va mas'uliyatli yondashuv.", 'en' => 'High service standard, expertise and responsible approach in every project.'],
                    ],
                    [
                        'icon'  => 'i-lucide-eye',
                        'title' => ['ru' => 'Прозрачность',   'uz' => 'Shaffoflik',        'en' => 'Transparency'],
                        'desc'  => ['ru' => 'Открытые процессы и честные партнёрские отношения без скрытых условий.', 'uz' => "Yashirin shartlarsiz ochiq jarayonlar va halol hamkorlik munosabatlari.", 'en' => 'Open processes and honest partnership without hidden conditions.'],
                    ],
                    [
                        'icon'  => 'i-lucide-trending-up',
                        'title' => ['ru' => 'Развитие',        'uz' => 'Rivojlanish',       'en' => 'Development'],
                        'desc'  => ['ru' => 'Постоянный рост компетенций, поддержка инноваций и цифровой трансформации.', 'uz' => "Kompetensiyalarning doimiy o'sishi, innovatsiyalar va raqamli transformatsiyani qo'llab-quvvatlash.", 'en' => 'Continuous growth of competencies, support for innovation and digital transformation.'],
                    ],
                    [
                        'icon'  => 'i-lucide-handshake',
                        'title' => ['ru' => 'Партнёрство',     'uz' => 'Hamkorlik',         'en' => 'Partnership'],
                        'desc'  => ['ru' => 'Долгосрочные союзы, основанные на взаимном доверии и общих целях.', 'uz' => "O'zaro ishonch va umumiy maqsadlarga asoslangan uzoq muddatli ittifoqlar.", 'en' => 'Long-term alliances built on mutual trust and common goals.'],
                    ],
                ],
            ],

            'leaders' => [
                'label'    => ['ru' => 'Руководство АУГЗ',  'uz' => 'AUGZ rahbariyati',        'en' => 'AUGZ Leadership'],
                'heading'  => ['ru' => "ЛИДЕРЫ\nКОТОРЫЕ РАЗВИВАЮТ\nБУДУЩЕЕ", 'uz' => "KELAJAKNI\nRIVOJLANTIRAYOTGAN\nLIDERLAR", 'en' => "LEADERS\nWHO SHAPE\nTHE FUTURE"],
                'subtitle' => [
                    'ru' => 'Команда профессионалов с многолетним опытом в сфере государственных закупок, стратегического и управленческого развития рынка Узбекистана.',
                    'uz' => "Davlat xaridlari, strategik va boshqaruv sohasida ko'p yillik tajribaga ega mutaxassislar jamoasi.",
                    'en' => 'A team of professionals with years of experience in public procurement, strategic and management development of the Uzbekistan market.',
                ],
                'items' => [
                    ['slug' => 'muhitdinov', 'name' => "Мухитдинов\nАнвар Омонуллаевич",    'role' => ['ru' => 'Председатель АУГЗ',             'uz' => 'AUGZ raisi',                         'en' => 'Chairman of AUGZ'],          'photo' => $this->img('leaders/muhitdinov.jpg')],
                    ['slug' => 'abidov',     'name' => "Абидов\nМарат Шавкатович",           'role' => ['ru' => 'Заместитель председателя АУГЗ', 'uz' => 'AUGZ rais o\'rinbosari',              'en' => 'Deputy Chairman of AUGZ'],   'photo' => $this->img('leaders/abidov.jpg')],
                    ['slug' => 'niyazov',    'name' => "Ниязов\nКамол Дильшодович",          'role' => ['ru' => 'Директор по стратегическому развитию', 'uz' => 'Strategik rivojlanish direktori', 'en' => 'Director of Strategic Development'], 'photo' => $this->img('leaders/niyazov.jpg')],
                    ['slug' => 'irmatova',   'name' => "Ирматова\nНигора Абдувайитовна",     'role' => ['ru' => 'Помощник председателя АУГЗ',    'uz' => 'AUGZ raisi yordamchisi',              'en' => 'Assistant to the Chairman'], 'photo' => $this->img('leaders/irmatova.jpg')],
                    ['slug' => 'hodjaev',    'name' => "Ходжаев\nФейруз Баходирович",        'role' => ['ru' => 'Эксперт АУГЗ',                  'uz' => 'AUGZ eksperti',                       'en' => 'AUGZ Expert'],              'photo' => $this->img('leaders/hodjaev.jpg')],
                    ['slug' => 'muratov',    'name' => "Муратов\nОдилжон",                   'role' => ['ru' => 'Эксперт АУГЗ',                  'uz' => 'AUGZ eksperti',                       'en' => 'AUGZ Expert'],              'photo' => $this->img('leaders/muratov.jpg')],
                ],
            ],

            'timeline' => [
                'label'   => ['ru' => 'С 2018 года',  'uz' => '2018 yildan',   'en' => 'Since 2018'],
                'heading' => ['ru' => 'НАША ИСТОРИЯ', 'uz' => 'BIZNING TARIXIMIZ', 'en' => 'OUR HISTORY'],
                'items' => [
                    ['year' => '2018', 'title' => ['ru' => 'Год основания',         'uz' => 'Tashkil etilgan yil',     'en' => 'Year founded'],        'desc' => ['ru' => 'Создание АУГЗ и первое объединение участников рынка госзакупок.',  'uz' => "AUGZ tashkil etildi va davlat xaridlari bozori ishtirokchilari birlashdi.",  'en' => 'AUGZ was founded and public procurement market participants were united.']],
                    ['year' => '2021', 'title' => ['ru' => 'Программы обучения',    'uz' => "O'quv dasturlari",        'en' => 'Training programs'],   'desc' => ['ru' => 'Запуск образовательных программ для брокеров и специалистов по закупкам.', 'uz' => "Brokerlar va xarid mutaxassislari uchun ta'lim dasturlari ishga tushirildi.", 'en' => 'Educational programs launched for brokers and procurement specialists.']],
                    ['year' => '2022', 'title' => ['ru' => '100+ участников',       'uz' => '100+ ishtirokchi',        'en' => '100+ members'],        'desc' => ['ru' => 'Ассоциация объединила более 100 компаний, брокеров и консультантов.',  'uz' => "Uyushma 100 dan ortiq kompaniya, broker va maslahatchilarni birlashtirdi.",  'en' => 'The association united over 100 companies, brokers and consultants.']],
                    ['year' => '2024', 'title' => ['ru' => 'Расширение партнёрств', 'uz' => 'Hamkorliklar kengayishi', 'en' => 'Expanding partnerships'], 'desc' => ['ru' => 'Расширение партнёрств с государственными органами и цифровые инициативы.', 'uz' => "Davlat organlari bilan hamkorliklar kengaytirildi va raqamli tashabbuslar boshlandi.", 'en' => 'Partnerships with government bodies expanded and digital initiatives launched.']],
                    ['year' => '2026', 'title' => ['ru' => 'Сегодня',               'uz' => 'Bugun',                   'en' => 'Today'],                'desc' => ['ru' => 'Свыше 1000 членов, 20+ проектов, лидер отрасли госзакупок.',        'uz' => "1000 dan ortiq a'zo, 20+ loyiha, davlat xaridlari sohasida yetakchi.",      'en' => 'Over 1000 members, 20+ projects, industry leader in public procurement.']],
                ],
            ],
        ];
    }

    private function newsContent(): array
    {
        return [
            'hero' => [
                'title'              => ['ru' => 'Новости и события',                              'uz' => 'Yangiliklar va tadbirlar',                             'en' => 'News and events'],
                'subtitle'           => ['ru' => 'Следите за последними новостями и событиями ассоциации.', 'uz' => "Uyushma so'nggi yangiliklari va tadbirlari bilan tanishing.", 'en' => 'Stay up to date with the latest news and events of the association.'],
                'search_placeholder' => ['ru' => 'Поиск по новостям...', 'uz' => 'Yangiliklar bo\'yicha qidirish...', 'en' => 'Search news...'],
            ],
        ];
    }

    private function servicesContent(): array
    {
        return [
            'hero' => [
                'image'    => null,
                'badge'    => ['ru' => 'УСЛУГИ И ПРОЕКТЫ АУГЗ',      'uz' => 'AUGZ XIZMATLARI VA LOYIHALARI',   'en' => 'AUGZ SERVICES AND PROJECTS'],
                'title_1'  => ['ru' => 'УСЛУГИ ',                     'uz' => 'XIZMATLAR ',                      'en' => 'SERVICES '],
                'title_2'  => ['ru' => 'АУГЗ',                        'uz' => 'AUGZ',                            'en' => 'AUGZ'],
                'subtitle' => ['ru' => 'Консалтинг, цифровые продукты, аналитика и сопровождение для участников государственных и корпоративных закупок Узбекистана', 'uz' => "Konsalting, raqamli mahsulotlar, tahlil va O'zbekiston davlat va korporativ xaridlari ishtirokchilari uchun hamrohlik", 'en' => 'Consulting, digital products, analytics and support for participants in Uzbekistan state and corporate procurement'],
                'categories' => [
                    ['label' => ['ru' => 'Консалтинг',        'uz' => 'Konsalting',             'en' => 'Consulting'],       'color' => '#D1832C'],
                    ['label' => ['ru' => 'Цифровые продукты', 'uz' => 'Raqamli mahsulotlar',    'en' => 'Digital Products'],  'color' => '#F59E0B'],
                    ['label' => ['ru' => 'Аналитика',         'uz' => 'Tahlil',                 'en' => 'Analytics'],         'color' => '#3B82F6'],
                    ['label' => ['ru' => 'Сопровождение',     'uz' => "Qo'llab-quvvatlash",    'en' => 'Support'],           'color' => '#10B981'],
                    ['label' => ['ru' => 'Сервисы',           'uz' => 'Servislar',              'en' => 'Services'],          'color' => '#8B5CF6'],
                ],
            ],
        ];
    }

    private function membershipContent(): array
    {
        return [
            'hero' => [
                'label'         => ['ru' => 'Членство в АУГЗ',     'uz' => "AUGZ a'zolik",             'en' => 'AUGZ Membership'],
                'heading_1'     => ['ru' => 'Станьте',              'uz' => "Qo'shiling",               'en' => 'Become'],
                'heading_2'     => ['ru' => 'Частью',               'uz' => 'Qismiga',                  'en' => 'Part'],
                'heading_3'     => ['ru' => 'Сообщества',           'uz' => 'Hamjamiyat',               'en' => 'Community'],
                'desc'          => ['ru' => 'Более 1000 компаний и специалистов уже используют возможности АУГЗ для роста бизнеса, получения тендеров и профессионального развития в сфере государственных закупок.', 'uz' => "1000 dan ortiq kompaniya va mutaxassislar allaqachon AUGZ imkoniyatlaridan foydalanmoqda.", 'en' => 'Over 1000 companies and specialists already use AUGZ opportunities for business growth, procurement and professional development.'],
                'btn_primary'   => ['label' => ['ru' => 'Вступить сейчас',   'uz' => "Hozir qo'shiling",  'en' => 'Join now'],   'href' => '#form'],
                'btn_secondary' => ['label' => ['ru' => 'Узнать подробнее',  'uz' => "Ko'proq bilish",    'en' => 'Learn more'], 'href' => '#benefits'],
            ],

            'benefits' => [
                'heading' => ['ru' => 'Преимущества членства', 'uz' => "A'zolik afzalliklari", 'en' => 'Membership benefits'],
                'items'   => [
                    ['icon' => 'heroicons:document-check', 'icon_bg' => 'bg-amber-900/60', 'title' => ['ru' => 'Сертификаты и статус',   'uz' => 'Sertifikatlar va maqom',       'en' => 'Certificates & status'],   'description' => ['ru' => 'Официальное подтверждение квалификации участника АУГЗ, признанное государственными структурами',    'uz' => "Davlat tuzilmalari tomonidan tan olingan AUGZ ishtirokchisi malakasining rasmiy tasdiqlanishi",          'en' => 'Official confirmation of AUGZ participant qualifications recognized by government structures']],
                    ['icon' => 'heroicons:bell',            'icon_bg' => 'bg-teal-900/60',   'title' => ['ru' => 'Доступ к тендерам',     'uz' => 'Tenderga kirish',              'en' => 'Access to tenders'],       'description' => ['ru' => 'Эксклюзивные уведомления о новых закупках и закрытые предложения только для членов ассоциации', 'uz' => "Yangi xaridlar bo'yicha eksklyuziv bildirishnomalar va faqat uyushma a'zolari uchun yopiq takliflar",   'en' => 'Exclusive notifications of new procurements and closed offers only for association members']],
                    ['icon' => 'heroicons:academic-cap',   'icon_bg' => 'bg-green-900/60',  'title' => ['ru' => 'Обучение и курсы',      'uz' => "Ta'lim va kurslar",            'en' => 'Training & courses'],      'description' => ['ru' => 'Учебные программы со скидкой до 50% для членов АУГЗ. Дистанционно и очно',                    'uz' => "AUGZ a'zolari uchun 50% gacha chegirma bilan o'quv dasturlari. Masofaviy va bevosita",               'en' => 'Training programs with up to 50% discount for AUGZ members. Remote and in-person']],
                    ['icon' => 'heroicons:heart',           'icon_bg' => 'bg-yellow-900/60', 'title' => ['ru' => 'Нетворкинг',            'uz' => 'Networking',                   'en' => 'Networking'],              'description' => ['ru' => 'Форумы, бизнес-встречи и партнёрские мероприятия для расширения деловых контактов',            'uz' => "Biznes aloqalarini kengaytirish uchun forumlar, biznes uchrashuvlar va hamkorlik tadbirlari",           'en' => 'Forums, business meetings and partnership events to expand business contacts']],
                    ['icon' => 'heroicons:chart-bar',       'icon_bg' => 'bg-indigo-900/60', 'title' => ['ru' => 'Аналитика рынка',       'uz' => 'Bozor tahlili',                'en' => 'Market analytics'],        'description' => ['ru' => 'Закрытые аналитические отчёты и данные по рынку государственных закупок Узбекистана',           'uz' => "O'zbekiston davlat xaridlari bozori bo'yicha yopiq tahliliy hisobotlar va ma'lumotlar",               'en' => 'Closed analytical reports and data on the Uzbekistan public procurement market']],
                    ['icon' => 'heroicons:scale',           'icon_bg' => 'bg-red-900/60',    'title' => ['ru' => 'Юридическая защита',    'uz' => 'Huquqiy himoya',               'en' => 'Legal protection'],        'description' => ['ru' => 'Консультации и сопровождение в спорных тендерных ситуациях от экспертов АУГЗ',                  'uz' => "AUGZ ekspertlaridan bahsli tender vaziyatlarida maslahat va yordam",                                    'en' => 'Consultations and support in disputed tender situations from AUGZ experts']],
                ],
            ],

            'member_types' => [
                'heading' => ['ru' => 'Кто может вступить', 'uz' => "Kim qo'shila oladi", 'en' => 'Who can join'],
                'items'   => [
                    ['icon' => 'heroicons:building-office-2', 'title' => ['ru' => 'Юридические лица',    'uz' => 'Yuridik shaxslar',          'en' => 'Legal entities'],    'description' => ['ru' => 'ООО, АО, ГУП и другие организации, участвующие в госзакупках',   'uz' => "MChJ, AJ, DUK va davlat xaridlarida ishtirok etuvchi boshqa tashkilotlar", 'en' => 'LLC, JSC, state enterprises and other organizations participating in public procurement']],
                    ['icon' => 'heroicons:user',              'title' => ['ru' => 'Физические лица',     'uz' => 'Jismoniy shaxslar',         'en' => 'Individuals'],       'description' => ['ru' => 'Специалисты и эксперты в сфере государственных закупок',         'uz' => "Davlat xaridlari sohasidagi mutaxassislar va ekspertlar",                    'en' => 'Specialists and experts in public procurement']],
                    ['icon' => 'heroicons:briefcase',         'title' => ['ru' => 'ИП / самозанятые',    'uz' => 'YT / mustaqil ishlovchilar','en' => 'Sole traders'],      'description' => ['ru' => 'Независимые консультанты и эксперты по закупочным процедурам', 'uz' => "Xarid tartib-qoidalari bo'yicha mustaqil maslahatchilar va ekspertlar",      'en' => 'Independent consultants and experts on procurement procedures']],
                    ['icon' => 'heroicons:globe-alt',         'title' => ['ru' => 'Иностранные компании', 'uz' => 'Xorijiy kompaniyalar',     'en' => 'Foreign companies'], 'description' => ['ru' => 'Нерезиденты, работающие на рынке Узбекистана',                  'uz' => "O'zbekiston bozorida faoliyat yurituvchi norezidentlar",                     'en' => 'Non-residents operating in the Uzbekistan market']],
                ],
            ],

            'form' => [
                'label'          => ['ru' => 'Вступление',          'uz' => "Qo'shilish",              'en' => 'Membership'],
                'heading'        => ['ru' => 'Подайте заявку',      'uz' => "Ariza bering",            'en' => 'Apply now'],
                'heading_accent' => ['ru' => 'на вступление',       'uz' => "qo'shilish uchun",        'en' => 'for membership'],
                'desc'           => ['ru' => 'Мы свяжемся с вами в течение 24 часов и расскажем обо всех возможностях членства в АУГЗ.', 'uz' => "Biz siz bilan 24 soat ichida bog'lanamiz va AUGZ a'zoligining barcha imkoniyatlari haqida gapirib beramiz.", 'en' => 'We will contact you within 24 hours and tell you about all the membership opportunities of AUGZ.'],
                'stat_value'     => '1000+',
                'stat_label'     => ['ru' => 'компаний и специалистов уже в сети АУГЗ', 'uz' => "kompaniya va mutaxassislar allaqachon AUGZ tarmog'ida", 'en' => 'companies and specialists already in the AUGZ network'],
                'trust_signals'  => [
                    ['icon' => 'heroicons:clock',        'bg' => 'bg-orange-500/10', 'color' => 'text-orange-400', 'title' => ['ru' => 'Ответ за 24 часа',          'uz' => '24 soat ichida javob',         'en' => 'Reply within 24h'],          'subtitle' => ['ru' => 'Менеджер свяжется лично',            'uz' => 'Menejer shaxsan bog\'lanadi',        'en' => 'A manager will contact you personally']],
                    ['icon' => 'heroicons:lock-closed',  'bg' => 'bg-green-500/10',  'color' => 'text-green-400',  'title' => ['ru' => 'Данные под защитой',        'uz' => "Ma'lumotlar himoyalangan",     'en' => 'Data is protected'],         'subtitle' => ['ru' => 'Не передаём третьим лицам',          'uz' => "Uchinchi shaxslarga bermayapmiz",    'en' => 'We do not share with third parties']],
                    ['icon' => 'heroicons:check-badge',  'bg' => 'bg-blue-500/10',   'color' => 'text-blue-400',   'title' => ['ru' => 'Бесплатная консультация',   'uz' => "Bepul maslahat",               'en' => 'Free consultation'],         'subtitle' => ['ru' => 'До подачи официальной заявки',       'uz' => "Rasmiy ariza berishdan oldin",       'en' => 'Before submitting an official application']],
                ],
            ],

            'ui' => [
                'breadcrumb_home'      => ['ru' => 'Главная',                    'uz' => 'Bosh sahifa',          'en' => 'Home'],
                'breadcrumb_current'   => ['ru' => 'Членство',                   'uz' => "A'zolik",              'en' => 'Membership'],
                'plans_label'          => ['ru' => 'Тарифы',                     'uz' => 'Tariflar',             'en' => 'Pricing'],
                'plans_heading'        => ['ru' => 'Выберите формат участия',    'uz' => "Ishtirok formatini tanlang", 'en' => 'Choose your plan'],
                'plans_popular_badge'  => ['ru' => 'Популярный',                 'uz' => 'Mashhur',              'en' => 'Popular'],
                'plans_free'           => ['ru' => 'Бесплатно',                  'uz' => 'Bepul',                'en' => 'Free'],
                'reviews_label'        => ['ru' => 'Отзывы',                     'uz' => 'Sharhlar',             'en' => 'Reviews'],
                'reviews_heading'      => ['ru' => 'Нам доверяют',               'uz' => 'Bizga ishonishadi',    'en' => 'Trusted by'],
                'form_name_label'      => ['ru' => 'Ваше имя',                   'uz' => 'Ismingiz',             'en' => 'Your name'],
                'form_name_placeholder'=> ['ru' => 'Фамилия Имя Отчество',       'uz' => 'Familiya Ism Sharif',  'en' => 'Full name'],
                'form_org_label'       => ['ru' => 'Организация',                'uz' => 'Tashkilot',            'en' => 'Organisation'],
                'form_org_placeholder' => ['ru' => 'Название компании или ИП',   'uz' => 'Kompaniya yoki YT nomi','en' => 'Company or sole trader name'],
                'form_phone_label'     => ['ru' => 'Телефон',                    'uz' => 'Telefon',              'en' => 'Phone'],
                'form_email_label'     => ['ru' => 'Email',                      'uz' => 'Email',                'en' => 'Email'],
                'form_plan_label'      => ['ru' => 'Тариф',                      'uz' => 'Tarif',                'en' => 'Plan'],
                'form_plan_placeholder'=> ['ru' => 'Выберите тариф',             'uz' => 'Tarifni tanlang',      'en' => 'Select a plan'],
                'form_plan_free'       => ['ru' => 'бесплатно',                  'uz' => 'bepul',                'en' => 'free'],
                'form_submit'          => ['ru' => 'Отправить заявку',           'uz' => 'Ariza yuborish',       'en' => 'Submit application'],
                'form_sending'         => ['ru' => 'Отправка...',                'uz' => 'Yuborilmoqda...',      'en' => 'Sending...'],
                'form_sent'            => ['ru' => 'Заявка отправлена',          'uz' => 'Ariza yuborildi',      'en' => 'Application sent'],
                'form_disclaimer'      => ['ru' => 'Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности АУГЗ', 'uz' => "Tugmani bosish orqali siz AUGZ maxfiylik siyosatiga rozilik bildirasiz", 'en' => 'By clicking the button you agree to the AUGZ privacy policy'],
                'err_name'             => ['ru' => 'Введите полное имя',          'uz' => "To'liq ismni kiriting", 'en' => 'Enter your full name'],
                'err_phone'            => ['ru' => 'Введите корректный номер телефона', 'uz' => "To'g'ri telefon raqamini kiriting", 'en' => 'Enter a valid phone number'],
                'err_email'            => ['ru' => 'Введите корректный email',    'uz' => "To'g'ri email kiriting", 'en' => 'Enter a valid email'],
            ],

            'cta' => [
                'badge'      => ['ru' => '1000+ членов уже с нами',          'uz' => "1000+ a'zo allaqachon biz bilan",    'en' => '1000+ members already with us'],
                'heading'    => ['ru' => "Готовы стать\nчастью",              'uz' => "A'zo bo'lishga tayyormisiz?",            'en' => "Ready to\nbecome part"],
                'accent'     => ['ru' => 'АУГЗ?',                             'uz' => 'AUGZ?',                              'en' => 'AUGZ?'],
                'desc'       => ['ru' => 'Вступите сегодня и получите доступ к возможностям, которые помогут вашему бизнесу расти в сфере государственных закупок.', 'uz' => "Bugun qo'shiling va davlat xaridlari sohasida biznesingizni o'stirishga yordam beradigan imkoniyatlarga kirish huquqiga ega bo'ling.", 'en' => 'Join today and get access to opportunities that will help your business grow in public procurement.'],
                'btn_primary'   => ['label' => ['ru' => 'Вступить в АУГЗ',  'uz' => "AUGZ ga qo'shilish", 'en' => 'Join AUGZ'],       'href' => '#form'],
                'btn_secondary' => ['label' => ['ru' => 'Задать вопрос',    'uz' => 'Savol berish',        'en' => 'Ask a question'],  'href' => '#form'],
            ],

            'ask_modal' => [
                'support_label'      => ['ru' => 'Поддержка АУГЗ',                             'uz' => "AUGZ qo'llab-quvvatlash",            'en' => 'AUGZ Support'],
                'title'              => ['ru' => 'Задать вопрос',                               'uz' => 'Savol berish',                       'en' => 'Ask a question'],
                'subtitle'           => ['ru' => 'Наш эксперт ответит в течение 2 рабочих часов', 'uz' => 'Ekspertimiz 2 ish soati ichida javob beradi', 'en' => 'Our expert will respond within 2 business hours'],
                'badge_time'         => ['ru' => 'Ответ за 2 часа',                             'uz' => '2 soat ichida javob',                'en' => 'Reply in 2 hours'],
                'badge_free'         => ['ru' => 'Бесплатно',                                   'uz' => 'Bepul',                              'en' => 'Free'],
                'badge_experts'      => ['ru' => 'Эксперты ассоциации',                         'uz' => 'Uyushma ekspertlari',                'en' => 'Association experts'],
                'category_label'     => ['ru' => 'Тема вопроса',                                'uz' => 'Savol mavzusi',                      'en' => 'Topic'],
                'categories'         => [
                    ['ru' => 'Тендеры',          'uz' => 'Tenderlar',     'en' => 'Tenders'],
                    ['ru' => 'Обучение',          'uz' => "Ta'lim",        'en' => 'Training'],
                    ['ru' => 'Правовой вопрос',   'uz' => 'Huquqiy savol', 'en' => 'Legal question'],
                    ['ru' => 'Telegram',          'uz' => 'Telegram',      'en' => 'Telegram'],
                    ['ru' => 'Закупки',           'uz' => 'Xaridlar',      'en' => 'Procurement'],
                    ['ru' => 'Другое',            'uz' => 'Boshqa',        'en' => 'Other'],
                ],
                'label_name'         => ['ru' => 'Имя',           'uz' => 'Ism',     'en' => 'Name'],
                'label_phone'        => ['ru' => 'Телефон',        'uz' => 'Telefon', 'en' => 'Phone'],
                'label_email'        => ['ru' => 'Email',          'uz' => 'Email',   'en' => 'Email'],
                'label_question'     => ['ru' => 'Ваш вопрос',     'uz' => 'Savolingiz', 'en' => 'Your question'],
                'btn_submit'         => ['ru' => 'Отправить вопрос', 'uz' => 'Savolni yuborish', 'en' => 'Send question'],
                'disclaimer'         => ['ru' => 'Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности АУГЗ', 'uz' => "Tugmani bosib, AUGZ maxfiylik siyosatiga rozilik bildirasiz", 'en' => 'By clicking the button you agree to the AUGZ privacy policy'],
                'success_title'      => ['ru' => 'Вопрос отправлен!',      'uz' => 'Savol yuborildi!',   'en' => 'Question sent!'],
                'success_subtitle'   => ['ru' => 'Эксперт АУГЗ ответит в течение 2 рабочих часов', 'uz' => 'AUGZ eksperti 2 ish soati ichida javob beradi', 'en' => 'An AUGZ expert will reply within 2 business hours'],
                'contacts_label'     => ['ru' => 'Контакты для связи',      'uz' => "Aloqa ma'lumotlari", 'en' => 'Contact details'],
                'contact_email'      => 'info@augz.uz',
                'contact_telegram'   => '@augz_uz',
                'working_hours'      => ['ru' => 'Пн–Пт, 9:00–18:00',       'uz' => 'Du–Ju, 9:00–18:00',  'en' => 'Mon–Fri, 9:00–18:00'],
                'btn_join'           => ['ru' => 'Вступить в АУГЗ',          'uz' => "AUGZ ga a'zo bo'lish", 'en' => 'Join AUGZ'],
                'btn_join_href'      => '/membership',
                'btn_close'          => ['ru' => 'Закрыть',                  'uz' => 'Yopish',             'en' => 'Close'],
            ],
        ];
    }

    private function contactsContent(): array
    {
        return [
            'hero' => [
                'badge'    => ['ru' => 'Наши контакты',    'uz' => 'Bizning kontaktlar', 'en' => 'Our contacts'],
                'title'    => ['ru' => 'КОНТАКТЫ',          'uz' => 'KONTAKTLAR',          'en' => 'CONTACTS'],
            ],
            'ui' => [
                'section_find_us'    => ['ru' => 'Как нас найти',        'uz' => 'Bizni qanday topish mumkin', 'en' => 'How to find us'],
                'open_in_maps'       => ['ru' => 'Открыть в картах',     'uz' => 'Xaritada ochish',            'en' => 'Open in maps'],
                'section_departments'=> ['ru' => 'Отделы АУГЗ',          'uz' => 'AUGZ bo\'limlari',           'en' => 'AUGZ Departments'],
                'col_dept'           => ['ru' => 'Отдел',                'uz' => 'Bo\'lim',                    'en' => 'Department'],
                'col_responsible'    => ['ru' => 'Ответственный',        'uz' => 'Mas\'ul',                    'en' => 'Responsible'],
                'col_contact'        => ['ru' => 'Контакт',              'uz' => 'Kontakt',                    'en' => 'Contact'],
                'section_socials'    => ['ru' => 'Мы в соцсетях',        'uz' => 'Ijtimoiy tarmoqlarda',       'en' => 'We in social media'],
                'form_title'         => ['ru' => 'Написать нам',         'uz' => 'Bizga yozing',               'en' => 'Write to us'],
                'form_subtitle'      => ['ru' => 'Ответим в течение дня', 'uz' => 'Kun ichida javob beramiz',  'en' => 'We reply within a day'],
                'field_name'         => ['ru' => 'Имя',                  'uz' => 'Ism',                        'en' => 'Name'],
                'field_name_ph'      => ['ru' => 'Ваше имя',             'uz' => 'Ismingiz',                   'en' => 'Your name'],
                'field_phone'        => ['ru' => 'Телефон',              'uz' => 'Telefon',                    'en' => 'Phone'],
                'field_phone_ph'     => ['ru' => '+998 ...',             'uz' => '+998 ...',                   'en' => '+998 ...'],
                'field_email'        => ['ru' => 'Email',                'uz' => 'Email',                      'en' => 'Email'],
                'field_email_ph'     => ['ru' => 'email@example.com',    'uz' => 'email@example.com',          'en' => 'email@example.com'],
                'field_subject'      => ['ru' => 'Тема',                 'uz' => 'Mavzu',                      'en' => 'Subject'],
                'field_subject_ph'   => ['ru' => 'Тема обращения',       'uz' => 'Murojaat mavzusi',           'en' => 'Subject of inquiry'],
                'field_message'      => ['ru' => 'Сообщение',            'uz' => 'Xabar',                      'en' => 'Message'],
                'field_message_ph'   => ['ru' => 'Ваше сообщение...',    'uz' => 'Xabaringiz...',              'en' => 'Your message...'],
                'btn_send'           => ['ru' => 'Отправить сообщение',  'uz' => 'Xabar yuborish',             'en' => 'Send message'],
                'btn_sending'        => ['ru' => 'Отправка...',          'uz' => 'Yuborilmoqda...',            'en' => 'Sending...'],
                'btn_sent'           => ['ru' => 'Отправлено!',          'uz' => 'Yuborildi!',                 'en' => 'Sent!'],
                'privacy_pre'        => ['ru' => 'Нажимая кнопку, вы соглашаетесь с', 'uz' => 'Tugmani bosib, siz', 'en' => 'By clicking, you agree to'],
                'privacy_link'       => ['ru' => 'политикой конфиденциальности', 'uz' => 'maxfiylik siyosatiga rozilik bildirasiz', 'en' => 'the privacy policy'],
                'privacy_post'       => ['ru' => '',                     'uz' => '',                           'en' => ''],
                'hotline'            => ['ru' => 'Горячая линия',        'uz' => 'Qo\'ng\'iroq liniyasi',      'en' => 'Hotline'],
                'telegram_label'     => ['ru' => 'Telegram',             'uz' => 'Telegram',                   'en' => 'Telegram'],
                'telegram_hint'      => ['ru' => 'Быстрый ответ',        'uz' => 'Tez javob',                  'en' => 'Fast response'],
                'email_label'        => ['ru' => 'Электронная почта',    'uz' => 'Elektron pochta',            'en' => 'Email'],
                'email_hint'         => ['ru' => 'Ответ в течение дня',  'uz' => 'Kun ichida javob',           'en' => 'Reply within a day'],
                'address_label'      => ['ru' => 'Адрес офиса',          'uz' => 'Ofis manzili',               'en' => 'Office address'],
                'map_error'          => ['ru' => 'Карта недоступна',     'uz' => 'Xarita mavjud emas',         'en' => 'Map unavailable'],
                'nav_home'           => ['ru' => 'Главная',              'uz' => 'Bosh sahifa',                'en' => 'Home'],
                'nav_contacts'       => ['ru' => 'Контакты',             'uz' => 'Kontaktlar',                 'en' => 'Contacts'],
            ],
        ];
    }

    private function reportContent(): array
    {
        return [
            'hero' => [
                'badge'    => ['ru' => 'Правовая защита АУГЗ',                    'uz' => "AUGZ huquqiy himoyasi",               'en' => 'AUGZ Legal Protection'],
                'title'    => ['ru' => 'ПОРТАЛ ЖАЛОБ',                            'uz' => 'SHIKOYATLAR PORTALI',                 'en' => 'COMPLAINTS PORTAL'],
                'subtitle' => ['ru' => 'Рассматриваем в течение 10 рабочих дней', 'uz' => '10 ish kunida ko\'rib chiqamiz',       'en' => 'Reviewed within 10 business days'],
            ],
            'info_banner' => [
                'text'       => ['ru' => 'Все обращения рассматриваются в течение',  'uz' => 'Barcha murojaatlar',                        'en' => 'All complaints are reviewed within'],
                'days'       => ['ru' => '10 рабочих дней.',                         'uz' => '10 ish kunida ko\'rib chiqiladi.',           'en' => '10 business days.'],
                'after_text' => ['ru' => 'После подачи вы получите',                 'uz' => 'Topshirgandan so\'ng siz olasiz',            'en' => 'After submission you will receive a'],
                'track_word' => ['ru' => 'трек-код',                                 'uz' => 'kuzatuv kodi',                               'en' => 'track code'],
                'suffix'     => ['ru' => '— прямо здесь.',                           'uz' => '— aynan shu yerda.',                         'en' => '— right here.'],
            ],
            'sidebar' => [
                'info_title' => ['ru' => 'Как рассматриваются обращения',             'uz' => 'Murojaatlar qanday ko\'rib chiqiladi',       'en' => 'How complaints are reviewed'],
                'info_items' => [
                    ['ru' => 'Все обращения рассматриваются в течение 10 рабочих дней',        'uz' => 'Barcha murojaatlar 10 ish kunida ko\'rib chiqiladi',         'en' => 'All complaints are reviewed within 10 business days'],
                    ['ru' => 'После подачи вы получите трек-код для отслеживания статуса',     'uz' => 'Topshirgandan so\'ng holat kuzatish uchun kod olasiz',       'en' => 'After submission you will receive a track code to follow your status'],
                    ['ru' => 'Конфиденциальность гарантирована при анонимной подаче',          'uz' => 'Anonim topshirishda maxfiylik kafolatlanadi',                 'en' => 'Confidentiality is guaranteed for anonymous submissions'],
                ],
                'stats' => [
                    ['icon' => 'ph:rocket-launch', 'value' => 'май 2026', 'label' => ['ru' => 'Запущен',                    'uz' => 'Ishga tushirildi',             'en' => 'Launched']],
                    ['icon' => 'ph:files',          'value' => 'dynamic',  'label' => ['ru' => 'Обращений принято',          'uz' => 'Murojaatlar qabul qilindi',    'en' => 'Complaints accepted'], 'dynamic' => true],
                    ['icon' => 'ph:clock',          'value' => 'до 10',    'label' => ['ru' => 'Среднее время ответа (рабочих дней)', 'uz' => "O'rtacha javob vaqti (ish kunlari)", 'en' => 'Avg response (business days)']],
                ],
            ],
            'form' => [
                'tabs' => [
                    'submit' => ['ru' => 'Подать жалобу',    'uz' => 'Shikoyat yuborish', 'en' => 'Submit complaint'],
                    'track'  => ['ru' => 'Отследить статус', 'uz' => 'Holat kuzatish',    'en' => 'Track status'],
                ],
                'steps' => [
                    ['label' => ['ru' => 'Детали',    'uz' => 'Tafsilotlar', 'en' => 'Details']],
                    ['label' => ['ru' => 'Документы', 'uz' => 'Hujjatlar',   'en' => 'Documents']],
                    ['label' => ['ru' => 'Контакты',  'uz' => 'Kontaktlar',  'en' => 'Contacts']],
                    ['label' => ['ru' => 'Готово',    'uz' => 'Tayyor',      'en' => 'Done']],
                ],
                'section1_title'     => ['ru' => 'Детали нарушения',        'uz' => 'Buzilish tafsilotlari',    'en' => 'Violation details'],
                'label_org'          => ['ru' => 'Организация-нарушитель',  'uz' => 'Qonunbuzar tashkilot',    'en' => 'Offending organisation'],
                'placeholder_org'    => ['ru' => 'Министерство финансов, ГУП «СтройИнвест»', 'uz' => 'Moliya vazirligi, DUK «QurilishInvest»', 'en' => 'Ministry of Finance, SUE "BuildInvest"'],
                'label_tender'       => ['ru' => 'Номер тендера',           'uz' => 'Tender raqami',           'en' => 'Tender number'],
                'placeholder_tender' => ['ru' => 'ЗКП-2026-XXXX',          'uz' => 'XSH-2026-XXXX',           'en' => 'TND-2026-XXXX'],
                'label_date'         => ['ru' => 'Дата нарушения',          'uz' => 'Buzilish sanasi',          'en' => 'Violation date'],
                'label_desc'         => ['ru' => 'Суть обращения',          'uz' => 'Murojaat mohiyati',        'en' => 'Complaint description'],
                'placeholder_desc'   => ['ru' => 'Опишите ситуацию подробно: что произошло, когда, какая организация замешана...', 'uz' => 'Vaziyatni batafsil tavsiflang: nima bo\'ldi, qachon, qaysi tashkilot...', 'en' => 'Describe the situation in detail: what happened, when, which organisation is involved...'],
                'section2_title'     => ['ru' => 'Документы',               'uz' => 'Hujjatlar',                'en' => 'Documents'],
                'section2_optional'  => ['ru' => 'необязательно',           'uz' => 'ixtiyoriy',                'en' => 'optional'],
                'upload_title'       => ['ru' => 'Перетащите файлы или нажмите', 'uz' => 'Fayllarni torting yoki bosing', 'en' => 'Drag files or click to upload'],
                'upload_hint'        => ['ru' => 'Скриншоты, документы, переписка', 'uz' => 'Skrinshotlar, hujjatlar, yozishmalar', 'en' => 'Screenshots, documents, correspondence'],
                'upload_formats'     => ['ru' => 'PDF · DOC · JPG · PNG — до 10 МБ · 5 файлов', 'uz' => 'PDF · DOC · JPG · PNG — 10 МБ gacha · 5 ta fayl', 'en' => 'PDF · DOC · JPG · PNG — up to 10 MB · 5 files'],
                'section3_title'     => ['ru' => 'Ваши данные',             'uz' => 'Sizning ma\'lumotlaringiz', 'en' => 'Your details'],
                'anon_label'         => ['ru' => 'Подать анонимно',         'uz' => 'Anonim yuborish',           'en' => 'Submit anonymously'],
                'anon_hint'          => ['ru' => 'Данные не будут переданы третьим лицам', 'uz' => 'Ma\'lumotlar uchinchi shaxslarga berilmaydi', 'en' => 'Your data will not be shared with third parties'],
                'label_name'         => ['ru' => 'Имя и Фамилия',           'uz' => 'Ism va Familiya',           'en' => 'Full name'],
                'placeholder_name'   => ['ru' => 'Иванов Иван',             'uz' => 'Toshmatov Anvar',           'en' => 'John Smith'],
                'label_sender_org'   => ['ru' => 'Организация',             'uz' => 'Tashkilot',                 'en' => 'Organisation'],
                'placeholder_sender_org' => ['ru' => 'ООО «Пример»',       'uz' => 'MChJ «Namuna»',             'en' => 'Example LLC'],
                'label_phone'        => ['ru' => 'Телефон',                 'uz' => 'Telefon',                   'en' => 'Phone'],
                'label_email'        => ['ru' => 'Email',                   'uz' => 'Email',                     'en' => 'Email'],
                'agree_text'         => ['ru' => 'Подтверждаю достоверность сведений и соглашаюсь с', 'uz' => 'Ma\'lumotlarning to\'g\'riligini tasdiqlayman va roziman', 'en' => 'I confirm the accuracy of the information and agree to the'],
                'agree_privacy'      => ['ru' => 'политикой конфиденциальности', 'uz' => 'maxfiylik siyosati',   'en' => 'privacy policy'],
                'agree_and'          => ['ru' => 'и',                       'uz' => 'va',                        'en' => 'and'],
                'agree_rules'        => ['ru' => 'правилами обработки обращений', 'uz' => 'murojaatlarni ko\'rib chiqish qoidalari', 'en' => 'complaints processing rules'],
                'btn_submit'         => ['ru' => 'Подать жалобу',           'uz' => 'Shikoyat yuborish',         'en' => 'Submit complaint'],
                'btn_call'           => ['ru' => 'Позвонить',               'uz' => 'Qo\'ng\'iroq qilish',      'en' => 'Call us'],
            ],
            'track' => [
                'sidebar_title'  => ['ru' => 'Как найти своё обращение',    'uz' => 'Murojaatingizni qanday topish mumkin', 'en' => 'How to find your complaint'],
                'sidebar_items'  => [
                    ['ru' => 'Введите трек-код в формате DXU-ГГГГ-ММ-XXXX',          'uz' => 'DXU-YYYY-OY-XXXX formatida kuzatuv kodini kiriting', 'en' => 'Enter the track code in DXU-YYYY-MM-XXXX format'],
                    ['ru' => 'Трек-код был выдан вам после подачи жалобы',            'uz' => 'Kuzatuv kodi shikoyat topshirilgandan keyin berildi',  'en' => 'The track code was issued after you submitted your complaint'],
                    ['ru' => 'Также он был отправлен на указанный email',             'uz' => 'U ko\'rsatilgan elektron pochta manziliga ham yuborildi', 'en' => 'It was also sent to the email address you provided'],
                ],
                'status_legend' => [
                    ['color' => 'bg-blue-400',   'label' => ['ru' => 'Принята',           'uz' => 'Qabul qilindi',         'en' => 'Received'],       'desc' => ['ru' => 'Жалоба зарегистрирована',          'uz' => 'Shikoyat ro\'yxatga olindi',        'en' => 'Complaint registered']],
                    ['color' => 'bg-indigo-400', 'label' => ['ru' => 'Анализ',            'uz' => 'Tahlil',                'en' => 'Analysis'],       'desc' => ['ru' => 'Эксперт изучает документы',        'uz' => 'Ekspert hujjatlarni o\'rganmoqda',   'en' => 'Expert reviewing documents']],
                    ['color' => 'bg-yellow-400', 'label' => ['ru' => 'На рассмотрении',   'uz' => 'Ko\'rib chiqilmoqda',   'en' => 'Under review'],   'desc' => ['ru' => 'Изучаются обстоятельства',          'uz' => 'Holat o\'rganilmoqda',               'en' => 'Circumstances being investigated']],
                    ['color' => 'bg-orange-400', 'label' => ['ru' => 'Ответ готовится',   'uz' => 'Javob tayyorlanmoqda', 'en' => 'Preparing reply'],'desc' => ['ru' => 'Формируется официальный ответ',    'uz' => 'Rasmiy javob shakllantirilmoqda',   'en' => 'Official reply being formed']],
                    ['color' => 'bg-green-500',  'label' => ['ru' => 'Завершено',         'uz' => 'Yakunlandi',           'en' => 'Closed'],         'desc' => ['ru' => 'Ответ отправлен заявителю',        'uz' => 'Javob ariza beruvchiga yuborildi',   'en' => 'Reply sent to applicant']],
                ],
                'search_title'       => ['ru' => 'Введите трек-код обращения',    'uz' => 'Murojaat kuzatuv kodini kiriting', 'en' => 'Enter complaint track code'],
                'search_hint'        => ['ru' => 'Код выдаётся сразу после подачи жалобы', 'uz' => 'Kod shikoyat topshirilgandan so\'ng beriladi', 'en' => 'Code is issued immediately after submitting a complaint'],
                'search_placeholder' => 'DXU-2026-05-XXXX',
                'btn_find'           => ['ru' => 'Найти',                          'uz' => 'Qidirish',                        'en' => 'Search'],
                'empty_title'        => ['ru' => 'Введите трек-код для поиска',    'uz' => 'Qidirish uchun kuzatuv kodini kiriting', 'en' => 'Enter a track code to search'],
                'empty_hint'         => ['ru' => 'Формат: DXU-ГГГГ-ММ-XXXX. Например, DXU-2026-05-4821', 'uz' => 'Format: DXU-YYYY-OY-XXXX. Masalan, DXU-2026-05-4821', 'en' => 'Format: DXU-YYYY-MM-XXXX. E.g. DXU-2026-05-4821'],
                'not_found_title'    => ['ru' => 'Обращение не найдено',           'uz' => 'Murojaat topilmadi',              'en' => 'Complaint not found'],
                'not_found_text'     => ['ru' => 'Проверьте правильность трек-кода. Если ошибка сохраняется — позвоните нам.', 'uz' => 'Kuzatuv kodining to\'g\'riligini tekshiring. Xato davom etsa — bizga qo\'ng\'iroq qiling.', 'en' => 'Please check the track code. If the issue persists — call us.'],
                'stages_title'       => ['ru' => 'Этапы рассмотрения',            'uz' => 'Ko\'rib chiqish bosqichlari',      'en' => 'Review stages'],
                'btn_new'            => ['ru' => 'Подать ещё одну жалобу',         'uz' => 'Yana bir shikoyat yuborish',       'en' => 'Submit another complaint'],
                'btn_call'           => ['ru' => 'Позвонить',                      'uz' => 'Qo\'ng\'iroq qilish',             'en' => 'Call us'],
            ],
            'success_modal' => [
                'title'         => ['ru' => 'ЖАЛОБА ПРИНЯТА!',                            'uz' => 'SHIKOYAT QABUL QILINDI!',                    'en' => 'COMPLAINT RECEIVED!'],
                'subtitle'      => ['ru' => 'Ваш трек-код сгенерирован — скопируйте его прямо сейчас', 'uz' => 'Kuzatuv kodingiz yaratildi — hoziroq nusxa oling', 'en' => 'Your track code has been generated — copy it now'],
                'track_label'   => ['ru' => 'Ваш трек-код обращения',                     'uz' => 'Murojaatingizning kuzatuv kodi',               'en' => 'Your complaint track code'],
                'btn_copy'      => ['ru' => 'Скопировать',   'uz' => 'Nusxa olish',        'en' => 'Copy'],
                'btn_copied'    => ['ru' => 'Скопировано',   'uz' => 'Nusxa olindi',       'en' => 'Copied'],
                'email_prefix'  => ['ru' => 'Код также отправлен на', 'uz' => 'Kod shuningdek yuborildi', 'en' => 'Code also sent to'],
                'meta_date'     => ['ru' => 'Дата подачи',   'uz' => 'Topshirish sanasi',   'en' => 'Submitted'],
                'meta_expert'   => ['ru' => 'Эксперт',       'uz' => 'Ekspert',             'en' => 'Expert'],
                'meta_deadline' => ['ru' => 'Срок ответа',   'uz' => 'Javob muddati',       'en' => 'Deadline'],
                'expert_name'   => ['ru' => 'Правовой отдел АУГЗ', 'uz' => 'AUGZ huquqiy bo\'limi', 'en' => 'AUGZ Legal Department'],
                'progress_steps' => [
                    ['label' => ['ru' => 'Принята',  'uz' => 'Qabul',    'en' => 'Received'], 'time' => ['ru' => 'сейчас',       'uz' => 'hozir',         'en' => 'now']],
                    ['label' => ['ru' => 'Анализ',   'uz' => 'Tahlil',   'en' => 'Analysis'], 'time' => ['ru' => '1 день',       'uz' => '1 kun',         'en' => '1 day']],
                    ['label' => ['ru' => 'Изучение', 'uz' => 'O\'rganish','en' => 'Review'],  'time' => ['ru' => '3–5 дней',     'uz' => '3–5 kun',       'en' => '3–5 days']],
                    ['label' => ['ru' => 'Позиция',  'uz' => 'Pozitsiya','en' => 'Position'], 'time' => ['ru' => '5–8 дней',     'uz' => '5–8 kun',       'en' => '5–8 days']],
                    ['label' => ['ru' => 'Ответ',    'uz' => 'Javob',    'en' => 'Reply'],    'time' => ['ru' => 'до 10 дней',   'uz' => '10 kungacha',   'en' => 'up to 10 days']],
                ],
                'btn_track' => ['ru' => 'Отследить статус по трек-коду', 'uz' => 'Kuzatuv kodi orqali holat kuzatish', 'en' => 'Track status by code'],
                'btn_close' => ['ru' => 'Закрыть',   'uz' => 'Yopish',   'en' => 'Close'],
            ],
        ];
    }

    private function marketsContent(): array
    {
        return [
            'hero' => [
                'badge'    => ['ru' => 'НАВИГАТОР ЗАКУПОК',    'uz' => 'XARIDLAR NAVIGATORI',    'en' => 'PROCUREMENT NAVIGATOR'],
                'title_1'  => ['ru' => 'ТОРГОВЫЕ ПЛОЩАДКИ',   'uz' => 'SAVDO MAYDONLARI',        'en' => 'TRADING PLATFORMS'],
                'title_2'  => ['ru' => 'УЗБЕКИСТАНА',          'uz' => "O'ZBEKISTONI",            'en' => 'OF UZBEKISTAN'],
                'subtitle' => [
                    'ru' => 'Полный каталог государственных и корпоративных закупочных платформ — официальные ссылки, описания и инструкции по регистрации',
                    'uz' => "O'zbekiston davlat va korporativ xarid platformalarining to'liq katalogi — rasmiy havolalar, tavsiflar va ro'yxatdan o'tish yo'riqnomalari",
                    'en' => 'A complete catalogue of state and corporate procurement platforms — official links, descriptions and registration guides',
                ],
            ],
        ];
    }

    private function tenderzoneContent(): array
    {
        return [
            'hero' => [
                'badge'    => ['ru' => 'Официальный партнёр АУГЗ Узбекистана', 'uz' => "O'zbekiston AUGZ rasmiy hamkori", 'en' => 'Official partner of AUGZ Uzbekistan'],
                'title_1'  => ['ru' => 'НАЙДИ НУЖНЫЙ',      'uz' => 'KERAKLI',           'en' => 'FIND THE RIGHT'],
                'title_2'  => ['ru' => 'ТЕНДЕР',             'uz' => 'TENDERNI',          'en' => 'TENDER'],
                'title_3'  => ['ru' => 'ПЕРВЫМ',             'uz' => 'BIRINCHI TOP',      'en' => 'FIRST'],
                'title_accent' => ['ru' => 'с TenderZone',    'uz' => 'TenderZone bilan',  'en' => 'with TenderZone'],
                'subtitle' => [
                    'ru' => 'Агрегатор государственных и корпоративных тендеров Узбекистана и СНГ. Уведомления, аналитика, статистика — всё в одной платформе.',
                    'uz' => "O'zbekiston va MDH davlat va korporativ tenderlarining agregatori. Bildirishnomalar, tahlil, statistika — barchasi bitta platformada.",
                    'en' => 'An aggregator of public and corporate tenders of Uzbekistan and the CIS. Notifications, analytics, statistics — all in one platform.',
                ],
                'btn_primary'   => ['label' => ['ru' => 'Начать бесплатно →', 'uz' => 'Bepul boshlash →', 'en' => 'Get started free →'], 'href' => 'https://tzone.uz'],
                'btn_secondary' => ['label' => ['ru' => 'Смотреть демо',      'uz' => 'Demoni ko\'rish',  'en' => 'Watch demo'],         'href' => '#'],
                'stats' => [
                    ['value' => '12 000+', 'label' => ['ru' => 'Тендеров ежедневно',  'uz' => 'Kunlik tenderlar',    'en' => 'Tenders per day']],
                    ['value' => '3 500+',  'label' => ['ru' => 'Активных компаний',   'uz' => 'Faol kompaniyalar',   'en' => 'Active companies']],
                    ['value' => '98%',     'label' => ['ru' => 'Охват площадок',      'uz' => 'Maydonchalar qamrovi','en' => 'Platform coverage']],
                ],
            ],

            'features' => [
                'badge'   => ['ru' => 'Возможности', 'uz' => 'Imkoniyatlar', 'en' => 'Features'],
                'heading' => ['ru' => 'ВСЁ ДЛЯ РАБОТЫ С ТЕНДЕРАМИ',      'uz' => 'TENDERLAR BILAN ISHLASH UCHUN HAMMA NARSA', 'en' => 'EVERYTHING FOR WORKING WITH TENDERS'],
                'subtitle'=> ['ru' => 'TenderZone — единая точка входа для поиска, анализа и участия в государственных и корпоративных закупках Узбекистана', 'uz' => "TenderZone — O'zbekiston davlat va korporativ xaridlarida qidirish, tahlil qilish va ishtirok etish uchun yagona kirish nuqtasi", 'en' => 'TenderZone is the single entry point for finding, analysing and participating in public and corporate procurement in Uzbekistan'],
                'items' => [
                    [
                        'icon' => 'ph:magnifying-glass', 'icon_color' => 'text-orange-500', 'border_color' => 'border-t-orange-400',
                        'title' => ['ru' => 'Умный поиск и фильтры',               'uz' => "Aqlli qidiruv va filtrlar",               'en' => 'Smart search and filters'],
                        'desc'  => ['ru' => 'Поиск по ключевым словам, ОКЭД, регионам, бюджету и срокам. Сохраняйте запросы — платформа ищет автоматически.', 'uz' => "Kalit so'zlar, OQED, mintaqalar, byudjet va muddatlar bo'yicha qidiruv. So'rovlarni saqlang.", 'en' => 'Search by keywords, OKED, regions, budget and deadlines. Save queries — the platform searches automatically.'],
                        'badge' => ['ru' => 'КЛЮЧЕВАЯ ФУНКЦИЯ', 'uz' => 'ASOSIY FUNKSIYA', 'en' => 'KEY FEATURE'],
                        'badge_color' => 'text-orange-600 bg-orange-50 border-orange-200',
                    ],
                    [
                        'icon' => 'ph:bell-ringing', 'icon_color' => 'text-blue-500', 'border_color' => 'border-t-blue-400',
                        'title' => ['ru' => 'Уведомления в реальном времени',      'uz' => 'Real vaqtli bildirishnomalar',            'en' => 'Real-time notifications'],
                        'desc'  => ['ru' => 'Мгновенные уведомления о новых тендерах через Telegram, email и push. Не пропустите ни одного подходящего тендера.', 'uz' => 'Yangi tenderlar haqida Telegram, email va push orqali tezkor bildirishnomalar.', 'en' => 'Instant notifications about new tenders via Telegram, email and push. Don\'t miss any suitable tender.'],
                        'badge' => ['ru' => 'TELEGRAM-БОТ', 'uz' => 'TELEGRAM-BOT', 'en' => 'TELEGRAM BOT'],
                        'badge_color' => 'text-blue-600 bg-blue-50 border-blue-200',
                    ],
                    [
                        'icon' => 'ph:chart-bar', 'icon_color' => 'text-green-500', 'border_color' => 'border-t-green-400',
                        'title' => ['ru' => 'Аналитика и конкуренты',              'uz' => 'Tahlil va raqobatchilar',                 'en' => 'Analytics and competitors'],
                        'desc'  => ['ru' => 'Анализ истории побед конкурентов, ценовые тренды и процент выигранных тендеров по категориям.', 'uz' => 'Raqobatchilarning g\'alaba tarixi tahlili, narx tendensiyalari va kategoriyalar bo\'yicha yutilgan tenderlar foizi.', 'en' => 'Analysis of competitors\' win history, price trends and the percentage of tenders won by category.'],
                        'badge' => ['ru' => 'ДАННЫЕ АУГЗ', 'uz' => "AUGZ MA'LUMOTLARI", 'en' => 'AUGZ DATA'],
                        'badge_color' => 'text-green-600 bg-green-50 border-green-200',
                    ],
                    [
                        'icon' => 'ph:robot', 'icon_color' => 'text-purple-500', 'border_color' => 'border-t-purple-400',
                        'title' => ['ru' => 'AI-помощник по заявкам',              'uz' => 'Arizalar bo\'yicha AI-yordamchi',          'en' => 'AI assistant for applications'],
                        'desc'  => ['ru' => 'Искусственный интеллект анализирует ТЗ и помогает подготовить заявку. Экономия до 80% времени.', 'uz' => 'Sun\'iy intellekt texnik topshiriqni tahlil qiladi va ariza tayyorlashga yordam beradi.', 'en' => 'AI analyses the TOR and helps prepare a bid. Save up to 80% of your time.'],
                        'badge' => ['ru' => 'BETA', 'uz' => 'BETA', 'en' => 'BETA'],
                        'badge_color' => 'text-purple-600 bg-purple-50 border-purple-200',
                    ],
                    [
                        'icon' => 'ph:files', 'icon_color' => 'text-orange-500', 'border_color' => 'border-t-orange-400',
                        'title' => ['ru' => 'Шаблоны документов',                  'uz' => 'Hujjat shablonlari',                      'en' => 'Document templates'],
                        'desc'  => ['ru' => 'Готовые шаблоны заявок и договоров. Автозаполнение данных — создавайте пакет документов за 30 минут.', 'uz' => 'Tayyor ariza va shartnoma shablonlari. Ma\'lumotlarni avtomatik to\'ldirish.', 'en' => 'Ready-made templates for applications and contracts. Auto-fill data — create a document package in 30 minutes.'],
                        'badge' => ['ru' => '50+ ШАБЛОНОВ', 'uz' => '50+ SHABLON', 'en' => '50+ TEMPLATES'],
                        'badge_color' => 'text-orange-600 bg-orange-50 border-orange-200',
                    ],
                    [
                        'icon' => 'ph:plug', 'icon_color' => 'text-gray-500', 'border_color' => 'border-t-gray-300',
                        'title' => ['ru' => 'API и интеграции',                    'uz' => 'API va integratsiyalar',                  'en' => 'API and integrations'],
                        'desc'  => ['ru' => 'REST API для интеграции с CRM или ERP. Готовые коннекторы для 1С, Bitrix24 и других систем.', 'uz' => 'CRM yoki ERP bilan integratsiya uchun REST API. 1C, Bitrix24 va boshqa tizimlar uchun tayyor konnektorlar.', 'en' => 'REST API for integration with CRM or ERP. Ready connectors for 1C, Bitrix24 and other systems.'],
                        'badge' => ['ru' => 'ДЛЯ РАЗРАБОТЧИКОВ', 'uz' => 'DASTURCHILAR UCHUN', 'en' => 'FOR DEVELOPERS'],
                        'badge_color' => 'text-gray-600 bg-gray-100 border-gray-200',
                    ],
                ],
            ],

            'how' => [
                'badge'   => ['ru' => 'Как работает',  'uz' => 'Qanday ishlaydi', 'en' => 'How it works'],
                'heading' => ['ru' => 'НАЧНИТЕ ЗА 5 МИНУТ', 'uz' => '5 DAQIQADA BOSHLANG', 'en' => 'START IN 5 MINUTES'],
                'btn_primary'   => ['label' => ['ru' => 'Начать бесплатно', 'uz' => 'Bepul boshlash',  'en' => 'Get started free'], 'href' => 'https://tzone.uz'],
                'btn_secondary' => ['label' => ['ru' => 'Запросить демо',   'uz' => 'Demo so\'rash',    'en' => 'Request a demo'],   'href' => '#'],
                'cta_hint' => ['ru' => 'Зарегистрируйтесь за 3 минуты и получите доступ к 150 000+ тендерам Узбекистана', 'uz' => "3 daqiqada ro'yxatdan o'ting va O'zbekistonning 150 000+ tenderiga kirish imkonini oling", 'en' => 'Register in 3 minutes and get access to 150,000+ tenders in Uzbekistan'],
                'steps' => [
                    ['title' => ['ru' => 'Регистрация',          'uz' => "Ro'yxatdan o'tish",   'en' => 'Registration'],           'desc' => ['ru' => 'Создайте аккаунт и заполните профиль компании — займёт 3 минуты',                 'uz' => "Hisob yarating va kompaniya profilini to'ldiring — 3 daqiqa vaqt oladi",               'en' => 'Create an account and fill in your company profile — it takes 3 minutes']],
                    ['title' => ['ru' => 'Настройка фильтров',   'uz' => 'Filtrlarni sozlash',   'en' => 'Set up filters'],         'desc' => ['ru' => 'Укажите ОКЭД, регионы и ценовой диапазон интересующих тендеров',                  'uz' => "Qiziqarli tenderlarning OQED, mintaqalari va narx diapazonini ko'rsating",             'en' => 'Specify the OKED, regions and price range of tenders you are interested in']],
                    ['title' => ['ru' => 'Получайте уведомления','uz' => 'Bildirishnomalar oling','en' => 'Receive notifications'],  'desc' => ['ru' => 'Telegram-бот или email — выберите удобный канал для оповещений',                  'uz' => 'Telegram-bot yoki email — qulay bildirishnoma kanalini tanlang',                       'en' => 'Telegram bot or email — choose a convenient notification channel']],
                    ['title' => ['ru' => 'Анализируйте тендер',  'uz' => 'Tenderni tahlil qiling','en' => 'Analyse the tender'],    'desc' => ['ru' => 'Изучите историю заказчика, конкурентов и оптимальную ценовую стратегию',           'uz' => 'Buyurtmachi tarixi, raqobatchilar va optimal narx strategiyasini o\'rganing',           'en' => 'Study the client\'s history, competitors and optimal pricing strategy']],
                    ['title' => ['ru' => 'Подавайте заявку',     'uz' => 'Ariza topshiring',      'en' => 'Submit your bid'],       'desc' => ['ru' => 'Используйте AI-помощник и шаблоны для быстрой подготовки документации',          'uz' => 'Hujjatlarni tez tayyorlash uchun AI-yordamchi va shablonlardan foydalaning',           'en' => 'Use the AI assistant and templates for quick document preparation']],
                ],
            ],

            'modal' => [
                'free_title'  => ['ru' => 'Начать бесплатно', 'uz' => 'Bepul boshlash', 'en' => 'Get started free'],
                'demo_title'  => ['ru' => 'Запросить демо',   'uz' => 'Demo so\'rash',   'en' => 'Request a demo'],
                'free_desc'   => ['ru' => 'Зарегистрируйтесь за 3 минуты и получите доступ к 150 000+ тендерам', 'uz' => "3 daqiqada ro'yxatdan o'ting va 150 000+ tenderga kirish imkonini oling", 'en' => 'Register in 3 minutes and get access to 150,000+ tenders'],
                'demo_desc'   => ['ru' => 'Наш менеджер свяжется с вами и проведёт демонстрацию',               'uz' => 'Menejerimiz siz bilan bog\'lanadi va namoyish o\'tkazadi',                    'en' => 'Our manager will contact you and conduct a demonstration'],
                'btn_free'    => ['ru' => 'Начать бесплатно →', 'uz' => 'Bepul boshlash →', 'en' => 'Get started free →'],
                'btn_demo'    => ['ru' => 'Запросить демо',     'uz' => 'Demo so\'rash',     'en' => 'Request a demo'],
            ],
        ];
    }

    private function regulationsContent(): array
    {
        return [
            'hero' => [
                'badge'    => ['ru' => 'ПРАВОВАЯ БАЗА',    'uz' => 'HUQUQIY BAZA',   'en' => 'LEGAL FRAMEWORK'],
                'title_1'  => ['ru' => 'НОРМАТИВНЫЕ',      'uz' => 'NORMATIV',        'en' => 'REGULATORY'],
                'title_2'  => ['ru' => 'ДОКУМЕНТЫ',        'uz' => 'HUJJATLAR',       'en' => 'DOCUMENTS'],
                'subtitle' => [
                    'ru' => 'Законодательство о государственных закупках Узбекистана: законы, указы Президента, постановления Кабинета Министров и ведомственные приказы',
                    'uz' => "O'zbekiston davlat xaridlari qonunchiligi: qonunlar, Prezident farmonlari, Vazirlar Mahkamasi qarorlari va idoraviy buyruqlar",
                    'en' => 'Public procurement legislation of Uzbekistan: laws, presidential decrees, cabinet resolutions and ministerial orders',
                ],
            ],
        ];
    }
}
