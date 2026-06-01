<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::truncate();

        $services = [
            // ── Консалтинг ──────────────────────────────────────────────────
            [
                'sort_order' => 1,
                'category'   => 'Консалтинг',
                'title'      => 'Тендерная стратегия и анализ рынка',
                'desc'       => 'Разработка индивидуальной стратегии участия в тендерах: анализ конкурентов, выбор перспективных лотов, ценовое позиционирование и прогноз вероятности победы.',
                'tags'       => ['СТРАТЕГИЯ', 'АНАЛИЗ КОНКУРЕНТОВ', 'ЦЕНООБРАЗОВАНИЕ'],
                'translations' => [
                    'uz' => ['title' => 'Tender strategiyasi va bozor tahlili',     'desc' => "Raqobatchilar tahlili, istiqbolli lotlarni tanlash, narx pozitsiyalash va g'alaba ehtimolini prognoz qilish."],
                    'en' => ['title' => 'Tender strategy and market analysis',       'desc' => 'Individual tender strategy: competitor analysis, lot selection, price positioning and win probability forecast.'],
                ],
            ],
            [
                'sort_order' => 2,
                'category'   => 'Консалтинг',
                'title'      => 'Подготовка тендерной документации',
                'desc'       => 'Полный пакет документов для участия в тендере: техническое предложение, ценовая заявка, банковские гарантии. Соответствие требованиям законодательства и ТЗ.',
                'tags'       => ['ДОКУМЕНТАЦИЯ', 'ЗАЯВКИ'],
                'translations' => [
                    'uz' => ['title' => 'Tender hujjatlarini tayyorlash',            'desc' => "Tenderda ishtirok etish uchun to'liq hujjatlar paketi: texnik taklif, narx takliflari, bank kafolatlari."],
                    'en' => ['title' => 'Tender documentation preparation',          'desc' => 'Full document package: technical proposal, price bid, bank guarantees. Legislative compliance.'],
                ],
            ],
            [
                'sort_order' => 3,
                'category'   => 'Консалтинг',
                'title'      => 'Правовой консалтинг и обжалование',
                'desc'       => 'Юридическая экспертиза тендерных условий, защита прав участников, подготовка жалоб и представительство интересов клиента в антимонопольных органах.',
                'tags'       => ['ПРАВО', 'ОБЖАЛОВАНИЕ'],
                'translations' => [
                    'uz' => ['title' => 'Huquqiy konsalting va shikoyat',            'desc' => 'Tender shartlarini yuridik ekspertizasi, ishtirokchilar huquqlarini himoya qilish, shikoyatlar tayyorlash.'],
                    'en' => ['title' => 'Legal consulting and appeals',              'desc' => "Legal audit of tender conditions, protection of participants' rights, complaint preparation and antitrust representation."],
                ],
            ],
            [
                'sort_order' => 4,
                'category'   => 'Консалтинг',
                'title'      => 'Аудит закупочных процедур',
                'desc'       => 'Независимая проверка закупочных процедур заказчика на соответствие требованиям законодательства, выявление рисков и рекомендации по улучшению.',
                'tags'       => ['АУДИТ', 'КОМПЛАЕНС', 'РИСКИ'],
                'translations' => [
                    'uz' => ['title' => 'Xarid tartib-qoidalarini audit qilish',     'desc' => "Buyurtmachining xarid tartib-qoidalarini qonunchilik talablariga muvofiqligini mustaqil tekshirish, xavflarni aniqlash."],
                    'en' => ['title' => 'Procurement procedure audit',               'desc' => 'Independent audit of procurement procedures for legislative compliance, risk identification and improvement recommendations.'],
                ],
            ],

            // ── Цифровые продукты ───────────────────────────────────────────
            [
                'sort_order' => 5,
                'category'   => 'Цифровые продукты',
                'title'      => 'TenderZone — агрегатор тендеров',
                'desc'       => 'Крупнейший агрегатор государственных и корпоративных тендеров Узбекистана. 15 000+ активных лотов, анализ и Telegram-уведомления в реальном времени.',
                'tags'       => ['ТЕНДЕРЫ', 'TELEGRAM', 'CRM'],
                'translations' => [
                    'uz' => ['title' => 'TenderZone — tenderlar agregatori',         'desc' => "O'zbekistonning eng yirik davlat va korporativ tenderlar agregatori. 15 000+ faol lot, tahlil va real vaqtda Telegram-bildirishnomalar."],
                    'en' => ['title' => 'TenderZone — tender aggregator',            'desc' => "Uzbekistan's largest aggregator of state and corporate tenders. 15,000+ active lots, analysis and real-time Telegram notifications."],
                ],
            ],
            [
                'sort_order' => 6,
                'category'   => 'Цифровые продукты',
                'title'      => 'АУГЗ Аналитика — платформа данных',
                'desc'       => 'Интерактивная платформа с данными о рынке государственных закупок: динамика цен, рейтинги поставщиков, региональная статистика и прогнозные модели.',
                'tags'       => ['АНАЛИТИКА', 'ДАШБОРДЫ', 'API', 'В РАЗРАБОТКЕ'],
                'translations' => [
                    'uz' => ['title' => 'AUGZ Analitika — ma\'lumotlar platformasi',  'desc' => "Davlat xaridlari bozori haqida ma'lumotlar bilan interaktiv platforma: narx dinamikasi, yetkazib beruvchilar reytingi, mintaqaviy statistika."],
                    'en' => ['title' => 'AUGZ Analytics — data platform',            'desc' => 'Interactive platform with public procurement market data: price dynamics, supplier rankings, regional statistics and forecasting models.'],
                ],
            ],
            [
                'sort_order' => 7,
                'category'   => 'Цифровые продукты',
                'title'      => 'Compliance Check — проверка рисков',
                'desc'       => 'Автоматическая проверка тендерной документации заказчика на соответствие законодательству. Выявление дискриминационных требований и коррупционных рисков.',
                'tags'       => ['КОМПЛАЕНС', 'РИСКИ', 'PILOT'],
                'translations' => [
                    'uz' => ['title' => 'Compliance Check — xatarlarni tekshirish',  'desc' => 'Buyurtmachining tender hujjatlarini qonunchilikka muvofiqligini avtomatik tekshirish. Kamsituvchi talablar va korrupsion xatarlarni aniqlash.'],
                    'en' => ['title' => 'Compliance Check — risk checker',           'desc' => 'Automatic compliance check of tender documentation against legislation. Detection of discriminatory requirements and corruption risks.'],
                ],
            ],
            [
                'sort_order' => 8,
                'category'   => 'Цифровые продукты',
                'title'      => 'AI TenderDoc — автозаполнение заявок',
                'desc'       => 'Искусственный интеллект анализирует техническое задание и автоматически генерирует конкурентоспособную заявку на участие в тендере за считанные минуты.',
                'tags'       => ['AI', 'АВТОМАТИЗАЦИЯ', 'СКОРО'],
                'translations' => [
                    'uz' => ['title' => "AI TenderDoc — arizalarni avtoto'ldirish",  'desc' => "Sun'iy intellekt texnik topshiriqni tahlil qiladi va bir necha daqiqada tenderda ishtirok etish uchun raqobatbardosh ariza avtomatik yaratadi."],
                    'en' => ['title' => 'AI TenderDoc — auto-fill applications',     'desc' => 'AI analyses the technical specification and automatically generates a competitive tender application in minutes.'],
                ],
            ],

            // ── Аналитика ───────────────────────────────────────────────────
            [
                'sort_order' => 9,
                'category'   => 'Аналитика',
                'title'      => 'Мониторинг рынка закупок',
                'desc'       => 'Ежеквартальные отчёты об объёмах, структуре и динамике рынка государственных закупок по секторам, регионам и типам процедур.',
                'tags'       => ['МОНИТОРИНГ', 'ОТЧЁТЫ'],
                'translations' => [
                    'uz' => ['title' => 'Xaridlar bozorini monitoring',              'desc' => "Davlat xaridlari bozorining hajmi, tuzilishi va dinamikasi bo'yicha choraklik hisobotlar."],
                    'en' => ['title' => 'Procurement market monitoring',             'desc' => 'Quarterly reports on volumes, structure and dynamics of the public procurement market by sectors, regions and procedure types.'],
                ],
            ],
            [
                'sort_order' => 10,
                'category'   => 'Аналитика',
                'title'      => 'Индекс прозрачности закупок',
                'desc'       => 'Рейтинг 14 регионов и крупнейших заказчиков по уровню прозрачности, конкурентности и цифровизации закупочных процедур.',
                'tags'       => ['РЕЙТИНГ', 'РЕГИОНЫ'],
                'translations' => [
                    'uz' => ['title' => 'Xaridlar shaffoflik indeksi',               'desc' => "14 mintaqa va eng yirik buyurtmachilarning shaffoflik, raqobatbardoshlik va raqamlashtirish darajasi bo'yicha reytingi."],
                    'en' => ['title' => 'Procurement transparency index',            'desc' => 'Ranking of 14 regions and major customers by transparency, competitiveness and digitalization of procurement procedures.'],
                ],
            ],
            [
                'sort_order' => 11,
                'category'   => 'Аналитика',
                'title'      => 'Реестр нарушений и рисков',
                'desc'       => 'База данных выявленных нарушений в тендерных процедурах — дискриминационные требования, аффилированные победители, манипуляции с ценами.',
                'tags'       => ['НАРУШЕНИЯ', 'ЗАКРЫТАЯ БД', 'ЧЛЕНЫ АУГЗ'],
                'translations' => [
                    'uz' => ['title' => 'Buzilishlar va xatarlar reestri',           'desc' => "Tender tartib-qoidalarida aniqlangan buzilishlar ma'lumotlar bazasi."],
                    'en' => ['title' => 'Violations and risks register',             'desc' => 'Database of identified violations in tender procedures — discriminatory requirements, affiliated winners, price manipulation.'],
                ],
            ],
            [
                'sort_order' => 12,
                'category'   => 'Аналитика',
                'title'      => 'Международные сравнения',
                'desc'       => 'Сравнительный анализ систем госзакупок Узбекистана, Казахстана, России, ОАЭ и других стран — лучшие практики и рекомендации для реформ.',
                'tags'       => ['МЕЖДУНАРОДНЫЙ', 'НА ЗАКАЗ'],
                'translations' => [
                    'uz' => ['title' => 'Xalqaro taqqoslashlar',                     'desc' => "O'zbekiston, Qozog'iston, Rossiya, BAA va boshqa mamlakatlar davlat xaridlari tizimlarining qiyosiy tahlili."],
                    'en' => ['title' => 'International comparisons',                 'desc' => 'Comparative analysis of procurement systems in Uzbekistan, Kazakhstan, Russia, UAE and other countries.'],
                ],
            ],

            // ── Сопровождение ───────────────────────────────────────────────
            [
                'sort_order' => 13,
                'category'   => 'Сопровождение',
                'title'      => 'Базовое сопровождение',
                'desc'       => 'Поддержка на этапе подготовки и подачи заявки. Проверка документов, консультации по требованиям ТЗ и ценовой стратегии.',
                'tags'       => ['ЗАЯВКА', 'ПРОВЕРКА', 'ОТ 500 000 СУМ'],
                'translations' => [
                    'uz' => ['title' => 'Asosiy hamrohlik',                          'desc' => "Ariza tayyorlash va topshirish bosqichida yordam. Hujjatlarni tekshirish, texnik shartlar va narx strategiyasi bo'yicha maslahatlar."],
                    'en' => ['title' => 'Basic support',                             'desc' => 'Support at the application preparation and submission stage. Document review, technical specification and pricing strategy consultations.'],
                ],
            ],
            [
                'sort_order' => 14,
                'category'   => 'Сопровождение',
                'title'      => 'Правовая защита',
                'desc'       => 'Полное юридическое сопровождение: обжалование дискриминационных условий, защита при отклонении заявки, представительство в ГЗКУ и Антимонопольном комитете.',
                'tags'       => ['ЮРИДИЧЕСКОЕ', 'ОБЖАЛОВАНИЕ', '98% УСПЕШНЫХ'],
                'translations' => [
                    'uz' => ['title' => 'Huquqiy himoya',                            'desc' => "To'liq yuridik hamrohlik: kamsituvchi shartlarga shikoyat, ariza rad etilganda himoya, DXKU va Monopoliyaga qarshi qo'mitada vakillik."],
                    'en' => ['title' => 'Legal protection',                          'desc' => 'Full legal support: appealing discriminatory conditions, protection against application rejection, representation before GPPA and Antimonopoly Committee.'],
                ],
            ],
            [
                'sort_order' => 15,
                'category'   => 'Сопровождение',
                'title'      => 'Комплексное VIP-сопровождение',
                'desc'       => 'Полный цикл от поиска тендера до исполнения контракта. Персональный менеджер, приоритетная поддержка 24/7 и гарантия качества результата.',
                'tags'       => ['VIP', 'ПЕРСОНАЛЬНЫЙ МЕНЕДЖЕР', '24/7'],
                'translations' => [
                    'uz' => ['title' => 'Kompleks VIP-hamrohlik',                    'desc' => "Tenderni topishdan shartnomani bajarishgacha to'liq tsikl. Shaxsiy menejer, 24/7 ustuvor qo'llab-quvvatlash va natija sifati kafolati."],
                    'en' => ['title' => 'Comprehensive VIP support',                 'desc' => 'Full cycle from tender search to contract execution. Personal manager, priority 24/7 support and quality result guarantee.'],
                ],
            ],

            // ── Сервисы ─────────────────────────────────────────────────────
            [
                'sort_order' => 16,
                'category'   => 'Сервисы',
                'title'      => 'Шаблоны документов',
                'desc'       => 'Библиотека из 50+ готовых шаблонов тендерных заявок, гарантийных писем, договоров и актов для Узбекистана.',
                'tags'       => ['ШАБЛОНЫ', '50+ ДОКУМЕНТОВ'],
                'translations' => [
                    'uz' => ['title' => 'Hujjat shablonlari',                        'desc' => "O'zbekiston uchun 50+ tayyor tender arizalari, kafolat xatlari, shartnomalar va dalolatnomalar kutubxonasi."],
                    'en' => ['title' => 'Document templates',                        'desc' => 'Library of 50+ ready-made templates for tender applications, guarantee letters, contracts and acts for Uzbekistan.'],
                ],
            ],
            [
                'sort_order' => 17,
                'category'   => 'Сервисы',
                'title'      => 'Telegram-мониторинг тендеров',
                'desc'       => 'Персонализированный бот для мгновенных уведомлений о новых тендерах по вашим параметрам — до 50 уведомлений в день.',
                'tags'       => ['TELEGRAM', 'УВЕДОМЛЕНИЯ', 'БОТ'],
                'translations' => [
                    'uz' => ['title' => 'Telegram-tender monitoringi',               'desc' => "Parametrlaringiz bo'yicha yangi tenderlar haqida tezkor bildirishnomalar uchun shaxsiylashtirilgan bot — kuniga 50 tagacha bildirishnoma."],
                    'en' => ['title' => 'Telegram tender monitoring',                'desc' => 'Personalised bot for instant notifications about new tenders by your parameters — up to 50 notifications per day.'],
                ],
            ],
            [
                'sort_order' => 18,
                'category'   => 'Сервисы',
                'title'      => 'Аккредитация на закупочных площадках',
                'desc'       => 'Помощь в регистрации и аккредитации на e-xarid.uz, TenderZone, cooperation.uz и других закупочных платформах.',
                'tags'       => ['АККРЕДИТАЦИЯ', 'E-XARID', 'TENDERZONE'],
                'translations' => [
                    'uz' => ['title' => 'Xarid maydonlarida akkreditatsiya',         'desc' => "e-xarid.uz, TenderZone, cooperation.uz va boshqa xarid platformalarida ro'yxatdan o'tish va akkreditatsiyada yordam."],
                    'en' => ['title' => 'Platform accreditation',                    'desc' => 'Assistance with registration and accreditation on e-xarid.uz, TenderZone, cooperation.uz and other procurement platforms.'],
                ],
            ],
            [
                'sort_order' => 19,
                'category'   => 'Сервисы',
                'title'      => 'PR и репутация',
                'desc'       => 'Размещение материалов о компании на площадках АУГЗ, участие в форумах как спикер, повышение узнаваемости на закупочном рынке.',
                'tags'       => ['PR', 'ФОРУМЫ', 'РЕПУТАЦИЯ'],
                'translations' => [
                    'uz' => ['title' => "PR va obro'",                               'desc' => "AUGZ platformalarida kompaniya haqida materiallarni joylashtirish, forumlarda spiker sifatida ishtirok etish."],
                    'en' => ['title' => 'PR & reputation',                           'desc' => 'Placement of company materials on AUGZ platforms, participation in forums as a speaker, increasing brand recognition in the procurement market.'],
                ],
            ],
            [
                'sort_order' => 20,
                'category'   => 'Сервисы',
                'title'      => 'Корпоративное обучение',
                'desc'       => 'Индивидуальные тренинги и воркшопы по госзакупкам для команды компании — офлайн в Ташкенте или онлайн.',
                'tags'       => ['ОБУЧЕНИЕ', 'КОРПОРАТИВНОЕ', 'ОНЛАЙН'],
                'translations' => [
                    'uz' => ['title' => "Korporativ ta'lim",                         'desc' => "Kompaniya jamoasi uchun individual treninglar va master-klasslar — Toshkentda oflayn yoki onlayn."],
                    'en' => ['title' => 'Corporate training',                        'desc' => 'Individual training and workshops on public procurement for your company team — offline in Tashkent or online.'],
                ],
            ],
        ];

        foreach ($services as $data) {
            Service::create($data);
        }
    }
}
