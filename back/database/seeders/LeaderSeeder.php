<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $base = rtrim(config('app.url'), '/');

        // Copy bundled photos into public storage so they're served immediately
        $src = database_path('seeders/assets/leaders');
        $dst = public_path('storage/leaders');
        if (File::isDirectory($src)) {
            File::ensureDirectoryExists($dst);
            foreach (File::files($src) as $file) {
                File::copy($file->getPathname(), $dst . '/' . $file->getFilename());
            }
        }

        $leaders = [
            [
                'sort_order'   => 1,
                'slug'         => 'muhitdinov',
                'name'         => "Мухитдинов\nАнвар Омонуллаевич",
                'role'         => 'Председатель АУГЗ',
                'photo'        => "{$base}/storage/leaders/muhitdinov.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ raisi'],
                    'en' => ['role' => 'Chairman of AUGZ'],
                ],
                'bio' => [
                    'ru' => 'Эксперт в области государственных закупок, тендерного законодательства и антикоррупционной методологии с более чем 20-летним опытом. Основал и возглавляет АУГЗ с 2018 года. Разрабатывает программы обучения и нормативно-правовые инициативы. Куратор Тендерной академии: многоязычные программы (RU, UZ, EN) по вопросам соответствия законодательству и антикоррупционным рискам. Ранее — брокер и юридический консультант на UzRTSB (2005–2018), более 10 лет биржевой практики.',
                    'uz' => 'Davlat xaridlari, tender qonunchiligi va korrupsiyaga qarshi metodologiya bo\'yicha 20 yildan ortiq tajribaga ega mutaxassis. 2018 yildan AUGZ raisi. O\'quv dasturlarini va me\'yoriy-huquqiy tashabbuslarni ishlab chiqadi. Tender akademiyasining kuratori: RU, UZ, EN tillarda ko\'p tilli o\'quv dasturlari. 2005–2018 yillarda UzRTSB\'da broker va yuridik maslahatchi.',
                    'en' => 'Expert in public procurement, tender legislation, and anti-corruption methodology with over 20 years of experience. Founded and leads AUGZ since 2018. Develops training programs and regulatory initiatives. Curator of the Tender Academy with multilingual curricula (RU, UZ, EN). Former broker and legal consultant at UzRTSB (2005–2018).',
                ],
            ],
            [
                'sort_order'   => 2,
                'slug'         => 'abidov',
                'name'         => "Абидов\nМарат Шавкатович",
                'role'         => 'Заместитель председателя АУГЗ',
                'photo'        => "{$base}/storage/leaders/abidov.jpg",
                'translations' => [
                    'uz' => ['role' => "AUGZ rais o'rinbosari"],
                    'en' => ['role' => 'Deputy Chairman of AUGZ'],
                ],
                'bio' => [
                    'ru' => 'Эксперт в области государственных и корпоративных закупок с более чем 12-летним практическим опытом. Один из первых в стране специалистов, систематизировавших обучение по тендерной тематике. Обучил более 1 000 предпринимателей и брокеров. Развивает AI-платформу обучения в сфере госзакупок в рамках Тендерной академии. Применяет методику обучения на реальных кейсах.',
                    'uz' => 'Davlat va korporativ xaridlar bo\'yicha 12 yildan ortiq amaliy tajribaga ega mutaxassis. Mamlakatimizdagi tender ta\'limini tizimlashtirgan dastlabki mutaxassislardan biri. 1 000 dan ortiq tadbirkor va brokerni o\'qitgan. Tender akademiyasida sun\'iy intellekt asosidagi o\'quv platformasini rivojlantirmoqda.',
                    'en' => 'Expert in public and corporate procurement with over 12 years of practical experience. One of the first specialists in the country to systematize tender education. Trained over 1,000 entrepreneurs and brokers. Developing an AI-powered training platform for public procurement within the Tender Academy.',
                ],
            ],
            [
                'sort_order'   => 3,
                'slug'         => 'niyazov',
                'name'         => "Ниязов\nКамол Дилшодович",
                'role'         => 'Независимый эксперт · Основатель Тендерной академии и TenderZone',
                'photo'        => "{$base}/storage/leaders/niyazov.jpg",
                'translations' => [
                    'uz' => ['role' => 'Mustaqil ekspert · Tender akademiyasi va TenderZone asoschisi'],
                    'en' => ['role' => 'Independent Expert · Founder of Tender Academy & TenderZone'],
                ],
                'bio' => [
                    'ru' => 'Предприниматель и инноватор в сфере закупок с более чем 13-летним опытом. Основатель Тендерной академии — AI-платформы обучения по госзакупкам. Провёл более 5 000 тендеров, обучил более 3 000 специалистов по всему СНГ. Основатель TenderZone LLC — ведущего агрегатора тендерных данных для СНГ. Аккредитованный брокер UzRTSB. Международная экспансия: США (NASPO Exchange 2026) и Китай (Canton Fair). Автор книги «Тендерчи: тизим сири».',
                    'uz' => 'Xaridlar sohasida 13 yildan ortiq tajribaga ega tadbirkor va innovator. Tender akademiyasi asoschisi — davlat xaridlari bo\'yicha sun\'iy intellekt asosidagi o\'quv platformasi. 5 000 dan ortiq tender o\'tkazgan, MDH bo\'ylab 3 000 dan ortiq mutaxassisni o\'qitgan. TenderZone LLC asoschisi. UzRTSB akkreditatsiyalangan brokeri. «Тендерчи: тизим сири» kitobining muallifi.',
                    'en' => 'Entrepreneur and innovator in procurement with over 13 years of experience. Founder of Tender Academy — an AI-powered platform for public procurement training. Conducted over 5,000 tenders, trained over 3,000 specialists across the CIS. Founder of TenderZone LLC. Accredited broker at UzRTSB. International expansion: USA (NASPO Exchange 2026) and China (Canton Fair). Author of the book "Tenderchi: tizim siri".',
                ],
            ],
            [
                'sort_order'   => 4,
                'slug'         => 'hodjaev',
                'name'         => "Ходжаев\nФейруз Баходирович",
                'role'         => 'Руководитель отдела ВЭД АУГЗ · Куратор Тендерной академии',
                'photo'        => "{$base}/storage/leaders/hodjaev.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ tashqi iqtisodiy faoliyat bo\'limi boshlig\'i · Tender akademiyasi kuratori'],
                    'en' => ['role' => 'Head of Foreign Economic Activity · Curator of Tender Academy'],
                ],
                'bio' => [
                    'ru' => 'Специалист по государственным закупкам и внешнеэкономической деятельности с опытом более 5 лет. Участвовал в крупных проектах суммарным объёмом свыше 1 500 000 долларов США. Член рабочей группы по вопросам государственных закупок. Курирует тендеры и обучение участников в АУГЗ, ведёт переговоры с иностранными партнёрами. Ранее — заместитель директора ООО Hiblak Printex (2001–2023), руководил отделом ВЭД.',
                    'uz' => 'Davlat xaridlari va tashqi iqtisodiy faoliyat bo\'yicha 5 yildan ortiq tajribaga ega mutaxassis. Jami 1 500 000 dollardan ortiq hajmdagi yirik loyihalarda ishtirok etgan. Davlat xaridlari bo\'yicha ishchi guruh a\'zosi. AUGZ\'da tender va ishtirokchilarni o\'qitishni boshqaradi.',
                    'en' => 'Specialist in public procurement and foreign economic activity with over 5 years of experience. Participated in major projects totalling over $1,500,000. Member of the working group on public procurement. Oversees tenders and participant training at AUGZ, negotiates with foreign partners.',
                ],
            ],
            [
                'sort_order'   => 5,
                'slug'         => 'muratov',
                'name'         => "Муратов\nОдилжон Махмуд угли",
                'role'         => 'Куратор АУГЗ · Аккредитованный брокер UzRTSB',
                'photo'        => "{$base}/storage/leaders/muratov.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ kuratori · UzRTSB akkreditatsiyalangan brokeri'],
                    'en' => ['role' => 'AUGZ Curator · Accredited Broker UzRTSB'],
                ],
                'bio' => [
                    'ru' => 'Эксперт по государственным закупкам и Узбекской республиканской товарно-сырьевой бирже с более чем 14-летним опытом. Специализируется на сопровождении закупочных процедур, биржевых торгах и работе с крупными лотами. Обучил более 1 000 участников. Сопровождает крупные тендеры и госзакупки на миллиарды сум. Лауреат награды за выдающиеся экспортные сделки (UZEX) и звания «Лучший куратор АУГЗ».',
                    'uz' => 'Davlat xaridlari va UzRTSB bo\'yicha 14 yildan ortiq tajribaga ega mutaxassis. Xarid tartib-taomillarini qo\'llab-quvvatlash, birja savdolari va yirik lotlar bilan ishlashda ixtisoslashgan. 1 000 dan ortiq ishtirokchini o\'qitgan. «AUGZ\'ning eng yaxshi kuratori» unvoni laureati.',
                    'en' => 'Expert in public procurement and the Uzbek Republican Commodity Exchange with over 14 years of experience. Specializes in supporting procurement procedures, exchange trading, and large-lot transactions. Trained over 1,000 participants. Laureate of the award for outstanding export deals (UZEX) and "Best AUGZ Curator".',
                ],
            ],
            [
                'sort_order'   => 6,
                'slug'         => 'irmatova',
                'name'         => "Ирматова\nНигора Абдувайитовна",
                'role'         => 'Помощник председателя АУГЗ',
                'photo'        => "{$base}/storage/leaders/irmatova.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ raisi yordamchisi'],
                    'en' => ['role' => 'Assistant to the Chairman of AUGZ'],
                ],
                'bio' => [
                    'ru' => 'Обеспечивает организационную и административную поддержку деятельности председателя АУГЗ. Координирует взаимодействие между структурными подразделениями ассоциации, ведёт документооборот и сопровождает протокольные мероприятия. Участвует в подготовке официальных встреч, форумов и переговоров с государственными органами и партнёрами. Контролирует исполнение поручений и решений руководства.',
                    'uz' => 'AUGZ raisi faoliyatiga tashkiliy va ma\'muriy yordam ko\'rsatadi. Assotsiatsiya bo\'limlari o\'rtasidagi hamkorlikni muvofiqlashtiradi, hujjat aylanmasini yuritadi va protokol tadbirlarini ta\'minlaydi. Rasmiy uchrashuvlar, forumlar va davlat organlari bilan muzokaralar tayyorlashda ishtirok etadi.',
                    'en' => 'Provides organizational and administrative support to the Chairman of AUGZ. Coordinates interaction between association divisions, manages document flow, and supports protocol events. Participates in preparing official meetings, forums, and negotiations with government bodies and partners.',
                ],
            ],
        ];

        foreach ($leaders as $data) {
            Leader::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
