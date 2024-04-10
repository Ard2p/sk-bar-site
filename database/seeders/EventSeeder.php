<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            'https://static.tildacdn.com/tild3435-6635-4661-b664-306538383561/_WhatsApp_2024-03-15.jpg',
            'https://static.tildacdn.com/tild3061-3465-4637-a564-333831323566/_WhatsApp_2024-03-25.jpg',
            'https://static.tildacdn.com/tild3062-6464-4063-a266-386565343764/_WhatsApp_2024-03-01.jpg',
            'https://static.tildacdn.com/tild3466-3261-4537-a636-643438626463/_WhatsApp_2024-03-29.jpg',
            'https://static.tildacdn.com/tild3138-3365-4230-b338-666233666236/ac51572d-a069-499f-b.jpeg',
            // '',
            // '',
            // '',
            // '',
        ];
        $banners = [
            'https://static.tildacdn.com/tild6662-3336-4837-b239-373830656561/_WhatsApp_2024-03-15.jpg',
            'https://static.tildacdn.com/tild3836-6662-4234-a535-323731653730/_WhatsApp_2024-03-25.jpg',
            'https://static.tildacdn.com/tild3730-3030-4266-b539-623761313962/_WhatsApp_2024-03-01.jpg',
            'https://static.tildacdn.com/tild3563-3061-4266-a233-623163366263/_WhatsApp_2024-03-29.jpg',
            'https://static.tildacdn.com/tild6266-3937-4132-b933-383239356461/WhatsApp_Image_2023-.jpeg',
            // '',
            // '',
            // '',
            // '',
        ];

        foreach ($images as $key => $image) {
            $images[$key] = Storage::disk('public')->put('events/image-' . $key . '.jpg', file_get_contents($image));
            $banners[$key] = Storage::disk('public')->put('events/banner-' . $key . '.jpg', file_get_contents($banners[$key]));
        }

        DB::table('events')->insert([
            [
                'name' => 'Трибьют шоу "Би-2"',
                'image' => 'events/image-0.jpg',
                'banner' => 'events/banner-0.jpg',
                'description' => 'ТРИБЬЮТ БИ-2 - 13 АПРЕЛЯ - SK BAR <br> <br> Трибьют шоу "Би-2" - Лучшие песни легендарных Би-2 будут сыграны группой "Чёрно-Белый".Максимально приближенное к оригиналу звучание!<br>Все кто уже был на концертах группы "Чёрно-Белый" знают, если закрыть глаза и послушать выступление группы, обязательно придёт ощущение реального концерта "Би-2"!<br>На своих концертах группа "Чёрно-Белый" всегда показывает зрителям, что такое настоящий рок. Более 20 лучших хитов "Би-2" разных лет – это более двух часов настоящего драйва!<br>Это будет вечер не просто живой музыки, это будет вечер доброты и мира, под самые душевные песни! <br>---------------------------------------------------------------------------<br>Билеты:<br><br>Бронь столов, заказ билетов - ☎ 36-26-26<br>---------------------------------------------------------------------------<br>Рок-кафе SK-BAR | Карла Маркса 47, Чебоксары |<br><br>13 апреля | открытие дверей 19:00 | Старт 20:00 <br><br><strong><strong data-redactor-tag="strong"><em>ООО Бар 1 ИНН 1655445242</em></strong></strong>',
                'event_start' => Carbon::parse('13.04.2024 20:00'),
                'guest_start' => Carbon::parse('13.04.2024 19:00'),
                'status' => 'publish',
                'age_limit' => '16',
                'place_id' => 1,
            ], [
                'name' => 'BIG Mama - Рок Весна!',
                'image' => 'events/image-1.jpg',
                'banner' => 'events/banner-1.jpg',
                'description' => 'BIG Mama - Рок Весна! 20 апреля - SK BAR! <br> <br> Весенняя рок вечеринка с кавер-группой "BIG Mama".<br>Любимые хиты русского рока, панка, альтернативы и классика зарубежного рока!<br><br>"BIG Mama" знает, какую музыку ты хочешь!<br>Танцпол уже ждёт вас! <br>---------------------------------------------------------------------------<br>Билеты:<br><br>Бронь столов, заказ билетов - ☎ 36-26-26<br>---------------------------------------------------------------------------<br>Рок-кафе SK-BAR | Карла Маркса 47, Чебоксары |<br><br>20 апреля | открытие дверей 19:00 | Старт 20:00 <br><br><strong><strong data-redactor-tag="strong"><em>ООО Бар 1 ИНН 1655445242</em></strong></strong>',
                'event_start' => Carbon::parse('20.04.2024 20:00'),
                'guest_start' => Carbon::parse('20.04.2024 19:00'),
                'status' => 'publish',
                'age_limit' => '16',
                'place_id' => 1,
            ], [
                'name' => 'Бригадный Подряд',
                'image' => 'events/image-2.jpg',
                'banner' => 'events/banner-2.jpg',
                'description' => 'Бригадный Подряд I 25.04.24 I Чебоксары - SK BAR <br> <br> Легендарная панк-рок группа «Бригадный Подряд» снова в Чебоксарах! <br> <br> Легендарная панк-рок группа «Бригадный Подряд» снова в Чебоксарах!<br><br>Короли Вселенского панк-рока выпустили новый альбом и представят его во всей мощи и красе!<br><br>Этот концерт станет особенным. Зрителей ждет незабываемая атмосфера, полная энергии и страсти. Группа сыграет свои хиты, которые стали классикой панк-рока, а также треки с нового долгожданного альбома.<br><br>Альбом "Нечего бояться" стал ярким продолжением творчества группы. В нем можно услышать искренние и проникновенные песни, которые дарят слушателям новые эмоции и впечатления.<br><br>«Бригадный Подряд» - вечно юные и безбашенные хулиганы из Санкт-Петербурга. В этот вечер зал наполнят лихие гитарные рифы, хлесткие рифмы, буйство и циркуляция энергетики.<br><br>А еще вас ждет мощь слэма, харизма «Бригадного Подряда» и незабываемые эмоции!<br><br>Встречаемся в Чебоксарах 25 Апреля в "SK BAR".<br>---------------------------------------------------------------------------<br>Билеты:<br><br>Бронь столов, заказ билетов - ☎ 36-26-26<br>---------------------------------------------------------------------------<br>Рок-кафе SK-BAR | Карла Маркса 47, Чебоксары |<br><br>25 апреля | открытие дверей 19:00 | Старт 20:00 <br><br><strong><strong data-redactor-tag="strong"><em>ООО Бар 1 ИНН 1655445242</em></strong></strong>',
                'event_start' => Carbon::parse('25.04.2024 20:00'),
                'guest_start' => Carbon::parse('25.04.2024 19:00'),
                'status' => 'publish',
                'age_limit' => '16',
                'place_id' => 1,
            ], [
                'name' => 'Трибьют Шоу - Руки Вверх & Звери',
                'image' => 'events/image-3.jpg',
                'banner' => 'events/banner-3.jpg',
                'description' => 'Трибьют Шоу - Руки Вверх &amp; Звери | 28.04 SK BAR <br> <br> Танцевальное трибьют шоу "Руки Вверх &amp; Звери"<br><br>Любишь ты Алешку больше чем Рому Зверя? Под чью песню "Танцуй" ты будешь зажигать больше?<br><br>Лучшие хиты групп «Руки Вверх» и «Звери» в лайв исполнении шоу группы «New Gorky». Никаких фонограмм, только настоящий, Живой звук! Полное погружение в шоу!<br><br>Кавер-шоу группа «New Gorky» – это настоящие "звезды" трибьют шоу, только драйв, позитив и высокое качество исполнения. Мы делаем шоу и это не просто слова. Вы сами это поймете, никто из зрителей не будет сидеть на месте, это мы гарантируем!<br><br>Ждём вас на сногсшибательный, танцевальный, даблтрибьют! <br>---------------------------------------------------------------------------<br>Билеты:<br><br>Бронь столов, заказ билетов - ☎ 36-26-26<br>---------------------------------------------------------------------------<br>Рок-кафе SK-BAR | Карла Маркса 47, Чебоксары |<br><br>28 апреля | открытие дверей 19:00 | Старт 20:00 <br><br><strong><strong data-redactor-tag="strong"><em>ООО Бар 1 ИНН 1655445242</em></strong></strong>',
                'event_start' => Carbon::parse('28.04.2024 20:00'),
                'guest_start' => Carbon::parse('28.04.2024 19:00'),
                'status' => 'publish',
                'age_limit' => '16',
                'place_id' => 1,
            ], [
                'name' => 'План Ломоносова',
                'image' => 'events/image-4.jpg',
                'banner' => 'events/banner-4.jpg',
                'description' => 'Мы группа «План Ломоносова»! Мы существуем с 2010 года, и за это время пережили много всего: радость от сочинения первых песен и впоследствии исполнение наших песен для тысяч людей, концерты и фестивали по России и за рубежом, участие в музыкальных теле-, радио- и интернет-передачах, записи песен на разных студиях нашей страны и мира, взлеты и периоды стагнации, время, когда группа была на грани распада, смены состава, пожары и наводнения, карантины и жесткие ограничения по проведению мероприятий, отмены и переносы концертов, отмену юбилейного тура, проведение сотен концертов в клубах от мала до велика и ещё много чего хорошего и не очень. Но, вопреки и благодаря всему, что с нами произошло за это время, благодаря поддержке нашей публики, наших родных и близких, вопреки людям, которые в нас не верили и не верят до сих пор, мы не просто выстояли, не просто существуем, но мы продолжаем сочинять и записывать новые песни в наш бесконечный альбом «План Ломоносова»! Бесконечный, потому что «План Ломоносова» – вечен и неубиваем! И с этим посланием, с новыми песнями и с хитами со всех наших пластинок мы отправляемся в тур! <br> ________________________________ <br><br><strong><strong data-redactor-tag="strong"><em>ООО Бар 1 ИНН 1655445242</em></strong></strong>',
                'event_start' => Carbon::parse('01.05.2024 20:00'),
                'guest_start' => Carbon::parse('01.05.2024 19:00'),
                'status' => 'publish',
                'age_limit' => '16',
                'place_id' => 1,
            ]

        ]);

        // Event::factory()->count(20)->create();
    }
}