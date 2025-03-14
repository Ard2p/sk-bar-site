<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Pages\Page;
use MoonShine\MoonShineUI;
use App\Models\MuzlotoGame;
use MoonShine\MoonShineRequest;
use GuzzleHttp\Cookie\CookieJar;

use Illuminate\Support\Facades\Http;
use App\Services\ExtTemplateProcessor;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use App\MoonShine\Pages\MuzlotoGame\MuzlotoGameFormPage;
use App\MoonShine\Pages\MuzlotoGame\MuzlotoGameIndexPage;
use App\MoonShine\Pages\MuzlotoGame\MuzlotoGameDetailPage;

/**
 * @extends ModelResource<MuzlotoGame>
 */
class MuzlotoGameResource extends ModelResource
{
    protected string $model = MuzlotoGame::class;

    protected string $title = 'MuzlotoGames';

    /**
     * @return list<Page>
     */
    public function pages(): array
    {
        return [
            MuzlotoGameIndexPage::make($this->title()),
            MuzlotoGameFormPage::make(
                $this->getItemID()
                    ? 'Управление'
                    : __('moonshine::ui.add')
                // ? __('moonshine::ui.edit')
                // : __('moonshine::ui.add')
            ),
            // MuzlotoGameDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    /**
     * @param MuzlotoGame $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }

    public function getFormItemButtons(): array
    {
        return [];
    }

    public function generateTickets(MoonShineRequest $request)
    {
        #Переменные с формы
        $sizeMatrix = 25;
        $ticketsCount = 500;
        $docTemplate = public_path('shemes/MuzlotoTemplate.docx');

        #Системные переменные
        $tracks = [
            'Кукушка – Кино',
            'Владимирский централ – Михаил Круг',
            'Комбат – Любэ',
            'Офицеры - Олег Газманов',
            'Возьми мое сердце - Ария',
            'Полковнику никто не пишет – Би 2',
            'Колхозный панк – Сектор Газа',
            'Поворот – Машина Времени',
            'Самый лучший день – Григорий Лепс',
            'Родина – ДДТ',
            'Медведь - КиШ',
            'Вечно молодой – Смысловые Галлюцинации',
            'На поле танки грохотали – Чиж и Со',
            'Мои ясные дни – Олег Гозманов',
            'Кустурица – Братья Грим',
            'Этот город – Браво',
            'Всадник из льда - Эпидемия',
            'Рюмка водки на столе – Григорий Лепс',
            'Однажды мир прогнется под нас – Машина времени',
            'Группа крови – Кино',
            'Штиль - Ария',
            'Мой рок-н-ролл – Би 2',
            'Перемен – Кино',
            'Конь -  Любэ',
            'Зеленоглазое такси – Михаил Боярский',
            'Это здорово – Николай Носков',
            'Как на войне – Агата Кристи',
            'Я то, что надо – Браво',
            'Пачка сигарет – Кино',
            'Там, за туманами – Любэ',
            'Демобилизация – Сектор Газа',
            'Позови меня тихо имени – Любэ',
            'Владивосток 2000 – Мумий Тролль',
            'Родина – АнимациЯ',
            'Последний герой – Би 2',
            'Ау – Ляпис Трубецкой',
            'Я свободен – Валерий Кипелов',
            'Я счастливый – Григорий Лепс',
            'Эскадрон – Олег Газманов',
            'Я люблю тебя до слез – Александр Серов',
            'Между мной и тобой – Оскар',
            'Младший лейтенант – Ирина Аллегрова',
            'Ах, какая женщина – Фристайл',
            'Пора домой – Сектор Газа',
            'Видение – Максим Леонидов',
            'Беспечный ангел – Ария',
            'Наперегонки с ветром – Корни',
            'Ром – КиШ',
            'Город – Аквариум',
            'WWW – Ленинград',
            'Медведица – Мумий Тролль',
            'Туман – Сектор Газа',
            'Давай за – Любэ',
            'Белый лебедь на пруду – Лесоповал',
            'Я поднимаю руки – Григорий Лепс',
            'Варвара – Би 2',
            'Фантом – Чиж и Со',
            'Сказочная тайга – Агата Кристи',
            'Мне бы в небо - Ленинград',
            'Капитал - Ляпис Трубецкой'
        ];

        $arrayNums = range(0, count($tracks) - 1);
        $docsBody = [];
        $arrayBingos = [];
        $arrayMd5s = [];
        $mainTemplateProcessor = null;

        # Генерация билета
        for ($i = 1; $i <= $ticketsCount; $i++) {

            shuffle($arrayNums);

            $arrayBingoTemp = array_slice($arrayNums, 0, $sizeMatrix);
            $md5 = md5(json_encode($arrayBingoTemp));

            if (!in_array($md5, $arrayMd5s)) {

                $arrayMd5s[] = $md5;
                $arrayBingos[]['array'] = $arrayBingoTemp;

                $templateProcessor = new ExtTemplateProcessor($docTemplate);

                $ticket = [];
                foreach ($arrayBingoTemp as $arrayBingoKey => $arrayBingoNum) {
                    // $ticket['bingo#' . $arrayBingoKey + 1] = ($arrayBingoNum + 1) . '. ' . $tracks[$arrayBingoNum];
                    $ticket['bingo#' . $arrayBingoKey + 1] = $tracks[$arrayBingoNum];
                }
                $ticket['ticketNumber'] = $i;

                $templateProcessor->setValues($ticket);

                if ($i == 1)
                    $mainTemplateProcessor = $templateProcessor;
                else
                    $docsBody[] = $templateProcessor->getBodyContent();
            }
        }

        #Сборка в 1 файл
        $strDocsBody = implode('', $docsBody);
        $mainTemplateProcessor->mergeXmlBody($strDocsBody);
        $mainTemplateProcessor->saveAs(Storage::disk('public')->path('bingo/main.docx'));

        // $array1 = [1, 2, 56, 43, 32, 34, 12, 23, 54, 13];
        // $array1 = array_rand($arrayNums, 20);
        // shuffle($array1);
        // $max = 0;
        // $avg = 0;
        // $avgCount = 0;
        // $maxCount = 0;
        // $maxCountWin = 0;
        // $stats = [
        //     'array' => join(' ', $array1),
        //     'length array' => count($array1),
        //     'array variation' => count($arrayNums),
        //     'tickets count' => $ticketsCount,
        //     'bingo 0' => 0,
        //     'bingo 1' => 0,
        //     'bingo 2' => 0,
        //     'bingo 3' => 0,
        //     'bingo 4' => 0,
        //     'bingo 5' => 0,
        //     'max 0' => 0,
        //     'max 1' => 0,
        //     'max 2' => 0,
        //     'max 3' => 0,
        //     'max 4' => 0,
        //     'max 5' => 0,
        // ];

        // $winMatrixs = [
        //     [0, 1, 2, 3, 4],
        //     [5, 6, 7, 8, 9],
        //     [10, 11, 12, 13, 14],
        //     [15, 16, 17, 18, 19],
        //     [20, 21, 22, 23, 24],

        //     [0, 5, 10, 15, 20],
        //     [1, 6, 11, 16, 21],
        //     [2, 7, 12, 17, 22],
        //     [3, 8, 13, 18, 23],
        //     [4, 9, 14, 19, 24],

        //     [0, 6, 12, 18, 24],
        //     [4, 8, 12, 16, 20],
        // ];

        // $winBingos = [];
        // // $random_keys = array_rand($columns[$j], 5);
        // foreach ($arrayBingos as $arrayBingoKey => $arrayBingo) {
        //     $result = array_intersect($arrayBingo['array'], $array1);

        //     if (count($result) > $max) $max = count($result);
        //     $avg += count($result) / $ticketsCount;

        //     $arrayBingos[$arrayBingoKey]['score'] = 0;

        //     $maxCurrent = 0;
        //     foreach ($winMatrixs as $winMatrix) {
        //         $arrayBingoKeys = array_keys($result);

        //         $countBingoWin = count(array_intersect($winMatrix, $arrayBingoKeys));

        //         match ($countBingoWin) {
        //             0 =>  $stats['bingo 0']++,
        //             1 =>  $stats['bingo 1']++,
        //             2 =>  $stats['bingo 2']++,
        //             3 =>  $stats['bingo 3']++,
        //             4 =>  $stats['bingo 4']++,
        //             5 =>  $stats['bingo 5']++,
        //         };

        //         if ($countBingoWin > $maxCountWin) $maxCountWin = $countBingoWin;
        //         if ($countBingoWin > $maxCurrent) $maxCurrent = $countBingoWin;

        //         if ($countBingoWin == 5) {
        //             $arrayBingos[$arrayBingoKey]['win'] = true;
        //             $arrayBingos[$arrayBingoKey]['matrix'] = join(' ', $winMatrix);
        //             $arrayBingos[$arrayBingoKey]['arrayBingoKeys'] = join(' ', $arrayBingoKeys);
        //             $arrayBingos[$arrayBingoKey]['result'] = join(' ', $result);
        //             $arrayBingos[$arrayBingoKey]['factorial'] = self::factorial($countBingoWin);
        //         }

        //         if ($countBingoWin > 0) {
        //             $countBingoWinScore = self::factorial($countBingoWin);
        //             $arrayBingos[$arrayBingoKey]['score'] += $countBingoWinScore;
        //         }
        //     }

        //     match ($maxCurrent) {
        //         0 =>  $stats['max 0']++,
        //         1 =>  $stats['max 1']++,
        //         2 =>  $stats['max 2']++,
        //         3 =>  $stats['max 3']++,
        //         4 =>  $stats['max 4']++,
        //         5 =>  $stats['max 5']++,
        //     };

        //     $avgCount += $maxCurrent / $ticketsCount;

        //     if ($arrayBingos[$arrayBingoKey]['score'] > $maxCount) $maxCount = $arrayBingos[$arrayBingoKey]['score'];

        //     if (isset($arrayBingos[$arrayBingoKey]['win'])) {
        //         $winBingos[] = $arrayBingos[$arrayBingoKey];
        //     }
        // }

        // $stats['avg max bingo'] = (float)number_format($avgCount, 2);
        // $stats['max score bingo'] = $maxCount;
        // $stats['max совпадение с выпавшими боченками'] = $max;
        // $stats['avg совпадение с выпавшими боченками'] = (float)number_format($avg, 2);

        // dd($stats, $winBingos);



        // $cookieJar = CookieJar::fromArray([
        //     '_login' => '123456',
        //     '_ordertable' => ''
        // ], '26.221.68.66');

        // $response = Http::withHeaders([
        //     'Server' => 'EncoreSrv',
        //     'Content-Type' => 'text/html'
        // ])
        //     ->withOptions(['cookies' => $cookieJar])
        //     ->post('http://26.221.68.66/', [
        //         'songTone' => 5,
        //         'SongNumb' => 2,
        //         'SongTab' => 1,
        //         'RunPlay' => '',
        //     ]);

        // dd($response);
        // $request->getResource()->getItem();
        // $request->getPage();

        MoonShineUI::toast('МоеСообщение', 'success');

        return back();
    }

    // public function download(): BinaryFileResponse
    // {
    //     // ...

    //     return response()->download($file);
    // }

    protected function factorial($num)
    {
        if ($num <= 1) {
            return 1;
        } else {
            return $num * self::factorial($num - 1);
        }
    }
}
