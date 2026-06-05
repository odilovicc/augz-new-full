<?php

namespace Database\Seeders;

use App\Models\RegulatoryDocument;
use Illuminate\Database\Seeder;

class RegulatoryDocumentSeeder extends Seeder
{
    public function run(): void
    {
        RegulatoryDocument::truncate();

        $documents = [
            // ЗАКОНЫ
            [
                'title'      => 'Закон РУз «О государственных закупках»',
                'type'       => 'law',
                'number'     => '№ЗРУ-684, 22.04.2021',
                'url'        => 'https://lex.uz/docs/5382983',
                'is_active'  => true,
                'sort_order' => 1,
            ],
            [
                'title'      => 'Закон РУз «О биржах и биржевой деятельности»',
                'type'       => 'law',
                'number'     => '№ЗРУ-375, 12.09.2014',
                'url'        => 'https://www.uzex.uz/ru/pages/regulatory-framework',
                'is_active'  => true,
                'sort_order' => 2,
            ],

            // УКАЗЫ ПРЕЗИДЕНТА
            [
                'title'      => 'Об очередных мерах по обеспечению конкурентной среды и прозрачности в системе госзакупок',
                'type'       => 'decree',
                'number'     => '№УП-259, 26.12.2025',
                'url'        => 'https://www.uzex.uz/ru/pages/regulatory-framework',
                'is_active'  => true,
                'sort_order' => 10,
            ],
            [
                'title'      => 'О мерах по реализации Закона РУз «О государственных закупках»',
                'type'       => 'decree',
                'number'     => '№ПП-3953, 27.09.2018',
                'url'        => 'https://xarid.uzex.uz/info/regulations',
                'is_active'  => true,
                'sort_order' => 11,
            ],
            [
                'title'      => 'О мерах по дальнейшему совершенствованию системы государственных закупок',
                'type'       => 'decree',
                'number'     => '№ПП-4544, 05.12.2019',
                'url'        => 'https://xarid.uzex.uz/info/regulations',
                'is_active'  => true,
                'sort_order' => 12,
            ],

            // ПОСТАНОВЛЕНИЯ КМ
            [
                'title'      => 'О порядке организации и проведения закупочных процедур',
                'type'       => 'resolution',
                'number'     => '№276, 20.05.2022',
                'url'        => 'https://lex.uz/docs/6026643',
                'is_active'  => true,
                'sort_order' => 20,
            ],
            [
                'title'      => 'Об утверждении положения о порядке определения товаров местного производства',
                'type'       => 'resolution',
                'number'     => '№712, 28.10.2024',
                'url'        => 'https://xarid.uzex.uz/info/regulations',
                'is_active'  => true,
                'sort_order' => 21,
            ],
            [
                'title'      => 'О дополнительных мерах по поддержке производителей в государственных закупках',
                'type'       => 'resolution',
                'number'     => '2025',
                'url'        => 'https://lex.uz/docs/7952218',
                'is_active'  => true,
                'sort_order' => 22,
            ],

            // ПРИКАЗЫ
            [
                'title'      => 'О деятельности оператора специального информационного портала госзакупок',
                'type'       => 'order',
                'number'     => '№3015, 21.05.2018',
                'url'        => 'https://xarid.uzex.uz/info/regulations',
                'is_active'  => true,
                'sort_order' => 30,
            ],
            [
                'title'      => 'О порядке рассмотрения жалоб в сфере государственных закупок',
                'type'       => 'order',
                'number'     => '№3013, 14.05.2018',
                'url'        => 'https://xarid.uzex.uz/info/regulations',
                'is_active'  => true,
                'sort_order' => 31,
            ],
        ];

        foreach ($documents as $doc) {
            RegulatoryDocument::create($doc);
        }
    }
}
