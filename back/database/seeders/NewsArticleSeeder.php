<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title'        => 'Новые правила игры на рынке закупок лекарств: сможет ли farma.xarid.uz снизить коррупцию?',
                'excerpt'      => 'Разбор новой платформы для закупок фармацевтической продукции — насколько она способна изменить прозрачность одного из самых коррупционных сегментов госзакупок.',
                'content'      => 'Подробный анализ новой платформы farma.xarid.uz, её функциональности и потенциала для снижения коррупционных рисков в секторе фармацевтических закупок.',
                'image'        => null,
                'is_featured'  => false,
                'category'     => 'analytics',
                'source'       => 'mypc.uz',
                'tags'         => ['госзакупки', 'фарма', 'реформа'],
                'views'        => 1240,
                'published_at' => '2026-02-17',
                'translations' => [
                    'uz' => [
                        'title'   => 'Dorivor vositalar xaridlari bozorida yangi qoidalar: farma.xarid.uz korrupsiyani kamaytira oladimi?',
                        'excerpt' => 'Farmatsevtika mahsulotlarini sotib olish uchun yangi platforma tahlili.',
                        'content' => 'farma.xarid.uz yangi platformasining batafsil tahlili.',
                    ],
                    'en' => [
                        'title'   => 'New rules in the pharmaceutical procurement market: can farma.xarid.uz reduce corruption?',
                        'excerpt' => 'Analysis of the new platform for pharmaceutical procurement.',
                        'content' => 'Detailed analysis of the new farma.xarid.uz platform.',
                    ],
                ],
            ],
            [
                'title'        => 'Центр риск-анализа в госзакупках: почему без ИИ бороться с коррупцией невозможно?',
                'excerpt'      => 'Концепция создания аналитического центра с применением искусственного интеллекта для автоматического выявления коррупционных рисков в закупочных процедурах.',
                'content'      => 'Разбор концепции создания аналитического центра с применением ИИ для автоматического выявления коррупционных рисков.',
                'image'        => null,
                'is_featured'  => true,
                'category'     => 'analytics',
                'source'       => 'mypc.uz',
                'tags'         => ['ИИ', 'коррупция', 'реформа'],
                'views'        => 980,
                'published_at' => '2026-01-08',
                'translations' => [
                    'uz' => [
                        'title'   => 'Davlat xaridlarida xavf tahlili markazi: nima uchun sun\'iy intellektsiz kurash mumkin emas?',
                        'excerpt' => 'Sun\'iy intellektdan foydalanib korrupsion xavflarni avtomatik aniqlash kontseptsiyasi.',
                        'content' => 'Sun\'iy intellektdan foydalanib korrupsion xavflarni aniqlash bo\'yicha tahliliy markazni yaratish kontseptsiyasini ko\'rib chiqish.',
                    ],
                    'en' => [
                        'title'   => 'Risk analysis center in public procurement: why fighting corruption without AI is impossible',
                        'excerpt' => 'Concept of an analytical center using AI to automatically identify corruption risks.',
                        'content' => 'Analysis of the concept of creating an analytical center using AI for automatic detection of corruption risks.',
                    ],
                ],
            ],
            [
                'title'        => 'ВАК Узбекистана провёл тендер на 564 млн сумов: победителем стала собственная структура',
                'excerpt'      => 'Как государственное ведомство организовало закупку таким образом, что победа оказалась у аффилированной организации — детальный разбор процедуры.',
                'content'      => 'Детальный разбор тендера ВАК Узбекистана на 564 млн сумов, в котором победила структура, аффилированная с самим ведомством.',
                'image'        => null,
                'is_featured'  => true,
                'category'     => 'investigation',
                'source'       => 'anhor.uz',
                'tags'         => ['тендер', 'расследование', 'надзор'],
                'views'        => 2100,
                'published_at' => '2025-10-14',
                'translations' => [
                    'uz' => [
                        'title'   => 'O\'zbekiston VAK 564 mln so\'mga tender o\'tkazdi: g\'olib o\'zining tuzilmasi bo\'ldi',
                        'excerpt' => 'Davlat idorasi qanday qilib o\'z tuzilmasi g\'alaba qozonishi uchun xaridni tashkil etganini batafsil tahlil.',
                        'content' => 'O\'zbekiston VAKning 564 mln so\'mga tenderini batafsil tahlil qilish.',
                    ],
                    'en' => [
                        'title'   => 'Uzbekistan HAC conducted a 564 million sum tender: its own structure won',
                        'excerpt' => 'How a government agency organized procurement so that an affiliated organization won.',
                        'content' => 'Detailed analysis of the HAC Uzbekistan tender for 564 million sums.',
                    ],
                ],
            ],
            [
                'title'        => 'Поставщик заявил о нарушениях при закупке насосов для BYD Uzbekistan Factory',
                'excerpt'      => 'Местный поставщик оспаривает итоги тендера на закупку промышленного оборудования — история о том, как устроены корпоративные закупки крупных совместных предприятий.',
                'content'      => 'История о нарушениях при проведении закупки промышленного оборудования для BYD Uzbekistan Factory.',
                'image'        => null,
                'is_featured'  => false,
                'category'     => 'investigation',
                'source'       => 'anhor.uz',
                'tags'         => ['BYD', 'тендер', 'биржа'],
                'views'        => 760,
                'published_at' => '2025-10-08',
                'translations' => [
                    'uz' => [
                        'title'   => 'Yetkazib beruvchi BYD Uzbekistan Factory uchun nasos xaridida qonun buzilishlarini e\'lon qildi',
                        'excerpt' => 'Mahalliy yetkazib beruvchi sanoat uskunalari xaridi tenderi natijalariga e\'tiroz bildirmoqda.',
                        'content' => 'BYD Uzbekistan Factory uchun sanoat uskunalari xaridida qonun buzilishlari haqida hikoya.',
                    ],
                    'en' => [
                        'title'   => 'Supplier claimed violations in pump procurement for BYD Uzbekistan Factory',
                        'excerpt' => 'Local supplier disputes results of industrial equipment procurement tender.',
                        'content' => 'Story about violations in procurement of industrial equipment for BYD Uzbekistan Factory.',
                    ],
                ],
            ],
            [
                'title'        => 'Как реформировать госзакупки в Узбекистане: проблемы, риски и пути решения',
                'excerpt'      => 'Системный анализ действующей закупочной системы — от правовых пробелов до отсутствия независимого контроля и монополизации тендеров.',
                'content'      => 'Системный анализ действующей закупочной системы Узбекистана с предложениями по реформированию.',
                'image'        => null,
                'is_featured'  => true,
                'category'     => 'legislation',
                'source'       => 'mypc.uz',
                'tags'         => ['реформа', 'законодательство', 'TenderZone'],
                'views'        => 1580,
                'published_at' => '2026-07-07',
                'translations' => [
                    'uz' => [
                        'title'   => 'O\'zbekistonda davlat xaridlarini qanday isloh qilish kerak: muammolar, xavflar va yechim yo\'llari',
                        'excerpt' => 'Amaldagi xarid tizimini tizimli tahlil qilish — huquqiy kamchiliklar va monopollashtirish.',
                        'content' => 'O\'zbekistonning amaldagi xarid tizimini isloh bo\'yicha takliflar bilan tizimli tahlil qilish.',
                    ],
                    'en' => [
                        'title'   => 'How to reform public procurement in Uzbekistan: problems, risks and solutions',
                        'excerpt' => 'Systematic analysis of the current procurement system — from legal gaps to monopolization.',
                        'content' => 'Systematic analysis of Uzbekistan\'s current procurement system with reform proposals.',
                    ],
                ],
            ],
            [
                'title'        => 'Тендер на $678 тыс. под подозрением: местных отсеяли, иностранцы победили с разницей $27',
                'excerpt'      => 'Детальный разбор конкретного тендера — как требования в документации были сформулированы так, что отечественные компании не смогли пройти отбор.',
                'content'      => 'Детальный разбор тендера на $678 тыс., в котором требования документации фактически исключили местных участников.',
                'image'        => null,
                'is_featured'  => true,
                'category'     => 'investigation',
                'source'       => 'anhor.uz',
                'tags'         => ['госзакупки', 'коррупция', 'надзор'],
                'views'        => 3200,
                'published_at' => '2026-05-09',
                'translations' => [
                    'uz' => [
                        'title'   => '$678 ming dollarlik tender shubha ostida: mahalliylar chetlashtirildi, xorijliklar $27 farq bilan g\'alaba qozondi',
                        'excerpt' => 'Hujjatlar talablari mahalliy kompaniyalar qatnasha olmasligi uchun qanday tuzilganini ko\'rsatuvchi tender tahlili.',
                        'content' => '$678 ming dollarlik tender batafsil tahlili.',
                    ],
                    'en' => [
                        'title'   => '$678k tender under suspicion: locals screened out, foreigners won by $27 difference',
                        'excerpt' => 'Analysis of a specific tender showing how documentation requirements effectively excluded local companies.',
                        'content' => 'Detailed analysis of the $678k tender where documentation requirements excluded local participants.',
                    ],
                ],
            ],
            [
                'title'        => 'Госзакупки в новом свете: местное ПО vs. зарубежная зависимость',
                'excerpt'      => 'Анализ проблемы технологической зависимости в государственных закупках программного обеспечения и аргументы за переход на отечественные решения.',
                'content'      => 'Анализ проблемы технологической зависимости государства от иностранного программного обеспечения.',
                'image'        => null,
                'is_featured'  => false,
                'category'     => 'analytics',
                'source'       => 'anhor.uz',
                'tags'         => ['ПО', 'ИИ', 'реформа'],
                'views'        => 890,
                'published_at' => '2026-05-30',
                'translations' => [
                    'uz' => [
                        'title'   => 'Davlat xaridlari yangi nuqtai nazardan: mahalliy dasturiy ta\'minot vs. xorijiy qaramlik',
                        'excerpt' => 'Davlat dasturiy ta\'minot xaridlarida texnologik qaramlik muammosi tahlili.',
                        'content' => 'Davlatning xorijiy dasturiy ta\'minotga texnologik qaramligi muammosi tahlili.',
                    ],
                    'en' => [
                        'title'   => 'Public procurement in new light: local software vs. foreign dependency',
                        'excerpt' => 'Analysis of technological dependency in government software procurement.',
                        'content' => 'Analysis of the state\'s technological dependency on foreign software.',
                    ],
                ],
            ],
            [
                'title'        => '«Необходимо им дать зубы»: эксперт о наблюдательной роли надзорных органов',
                'excerpt'      => 'Почему надзорные органы не могут эффективно контролировать закупочный рынок и что нужно изменить на законодательном уровне.',
                'content'      => 'Интервью с экспертом о недостатках действующей системы надзора за государственными закупками.',
                'image'        => null,
                'is_featured'  => false,
                'category'     => 'analytics',
                'source'       => 'anhor.uz',
                'tags'         => ['надзор', 'реформа', 'коррупция'],
                'views'        => 640,
                'published_at' => '2026-05-26',
                'translations' => [
                    'uz' => [
                        'title'   => '«Ularga tish berish kerak»: ekspert nazorat organlarining kuzatuv roli haqida',
                        'excerpt' => 'Nima uchun nazorat organlari xarid bozorini samarali nazorat qila olmaydi.',
                        'content' => 'Davlat xaridlari ustidan amaldagi nazorat tizimidagi kamchiliklar haqida ekspert bilan suhbat.',
                    ],
                    'en' => [
                        'title'   => '"They need to be given teeth": expert on the supervisory role of oversight bodies',
                        'excerpt' => 'Why oversight bodies cannot effectively control the procurement market.',
                        'content' => 'Interview with an expert about shortcomings of the current oversight system for public procurement.',
                    ],
                ],
            ],
            [
                'title'        => 'Ежегодная конференция по госзакупкам: итоги и резолюция',
                'excerpt'      => 'Ключевые выводы, принятые решения и дорожная карта реформирования системы государственных закупок Узбекистана по итогам отраслевого форума.',
                'content'      => 'Итоги ежегодной конференции АУГЗ по государственным закупкам.',
                'image'        => '/img/cons5.png',
                'is_featured'  => false,
                'category'     => 'event',
                'source'       => 'augz.uz',
                'tags'         => ['конференция', 'реформа', 'госзакупки'],
                'views'        => 420,
                'published_at' => '2026-04-15',
                'translations' => [
                    'uz' => [
                        'title'   => 'Davlat xaridlari bo\'yicha yillik konferensiya: yakunlar va rezolyutsiya',
                        'excerpt' => 'Tarmoq forumi natijasida O\'zbekistonda davlat xaridlari tizimini isloh qilish yo\'l xaritasi.',
                        'content' => 'AUGZ davlat xaridlari bo\'yicha yillik konferensiya yakunlari.',
                    ],
                    'en' => [
                        'title'   => 'Annual Public Procurement Conference: results and resolution',
                        'excerpt' => 'Key findings, decisions made and roadmap for reforming Uzbekistan\'s public procurement system.',
                        'content' => 'Results of AUGZ annual conference on public procurement.',
                    ],
                ],
            ],
            [
                'title'        => 'Подписание меморандума с Агентством по противодействию коррупции',
                'excerpt'      => 'Подписан меморандум о сотрудничестве между АУГЗ и Агентством по противодействию коррупции Республики Узбекистан.',
                'content'      => 'Меморандум закрепляет совместные усилия АУГЗ и Агентства по противодействию коррупции в области мониторинга государственных закупок.',
                'image'        => '/img/cons3.png',
                'is_featured'  => false,
                'category'     => 'news',
                'source'       => 'augz.uz',
                'tags'         => ['АУГЗ', 'коррупция', 'меморандум'],
                'views'        => 530,
                'published_at' => '2026-04-08',
                'translations' => [
                    'uz' => [
                        'title'   => 'Korrupsiyaga qarshi kurashish agentligi bilan memorandum imzolash',
                        'excerpt' => 'AUGZ va O\'zbekiston Respublikasi Korrupsiyaga qarshi kurashish agentligi o\'rtasida hamkorlik memorandumi imzolandi.',
                        'content' => 'Memorandum AUGZ va Korrupsiyaga qarshi kurashish agentligining davlat xaridlarini monitoring qilish sohasidagi birgalikdagi sa\'y-harakatlarini mustahkamlaydi.',
                    ],
                    'en' => [
                        'title'   => 'Signing of memorandum with the Anti-Corruption Agency',
                        'excerpt' => 'A memorandum of cooperation was signed between AUGZ and the Anti-Corruption Agency of Uzbekistan.',
                        'content' => 'The memorandum consolidates joint efforts of AUGZ and the Anti-Corruption Agency in monitoring public procurement.',
                    ],
                ],
            ],
            [
                'title'        => 'Public & Corporate Procurement Forum Uzbekistan 2026',
                'excerpt'      => 'Форум объединил ведущих экспертов для обсуждения цифровизации закупок, международного сотрудничества и новых механизмов прозрачности.',
                'content'      => 'Ежегодный форум стал площадкой для диалога между бизнесом, государством и международными организациями.',
                'image'        => '/img/cons5.png',
                'is_featured'  => true,
                'category'     => 'event',
                'source'       => 'augz.uz',
                'tags'         => ['форум', 'цифровизация', 'TenderZone'],
                'views'        => 1100,
                'published_at' => '2026-05-01',
                'translations' => [
                    'uz' => [
                        'title'   => 'O\'zbekiston davlat va korporativ xaridlar forumi 2026',
                        'excerpt' => 'Forum xaridlarni raqamlashtirish, xalqaro hamkorlik va yangi shaffoflik mexanizmlarini muhokama qilish uchun yetakchi mutaxassislarni birlashtirdi.',
                        'content' => 'Yillik forum biznes, davlat va xalqaro tashkilotlar o\'rtasidagi muloqot maydoni bo\'ldi.',
                    ],
                    'en' => [
                        'title'   => 'Public & Corporate Procurement Forum Uzbekistan 2026',
                        'excerpt' => 'The forum brought together leading experts to discuss procurement digitalization, international cooperation and new transparency mechanisms.',
                        'content' => 'The annual forum became a platform for dialogue between business, government and international organizations.',
                    ],
                ],
            ],
        ];

        foreach ($articles as $data) {
            NewsArticle::updateOrCreate(
                ['title' => $data['title']],
                $data,
            );
        }
    }
}
