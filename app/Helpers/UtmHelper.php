<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class UtmHelper
{
    /**
     * Список UTM параметров для обработки
     */
    protected array $utmParamNames = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    /**
     * Применяет UTM параметры к URL
     *
     * @param string $url Исходный URL
     * @return string URL с примененными UTM параметрами
     */
    public function linkWithUTM(string $url): string
    {
        $utmParams = $this->getUtmParams();

        // Если нет UTM параметров, возвращаем исходный URL
        if (empty($utmParams)) {
            return $url;
        }

        // Применяем UTM параметры к URL
        $urlParts = parse_url($url);
        if ($urlParts === false) {
            return $url;
        }

        $query = [];
        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $query);
        }

        // Объединяем существующие параметры с UTM параметрами
        $query = array_merge($query, $utmParams);

        // Собираем новый URL
        $newUrl = '';
        if (isset($urlParts['scheme'])) {
            $newUrl .= $urlParts['scheme'] . '://';
        }
        if (isset($urlParts['host'])) {
            $newUrl .= $urlParts['host'];
        }
        if (isset($urlParts['port'])) {
            $newUrl .= ':' . $urlParts['port'];
        }
        if (isset($urlParts['path'])) {
            $newUrl .= $urlParts['path'];
        }
        $newUrl .= '?' . http_build_query($query);
        if (isset($urlParts['fragment'])) {
            $newUrl .= '#' . $urlParts['fragment'];
        }

        return $newUrl;
    }

    /**
     * Получает UTM параметры из текущего запроса или cookies
     *
     * @return array Массив UTM параметров
     */
    public function getUtmParams(): array
    {
        $utmParams = [];

        foreach ($this->utmParamNames as $param) {
            // Приоритет: сначала из запроса, потом из cookies
            $value = request()->get($param);
            if (empty($value)) {
                $value = request()->cookie($param);
            }
            if (!empty($value)) {
                $utmParams[$param] = $value;
            }
        }

        return $utmParams;
    }

    /**
     * Получает конкретный UTM параметр
     *
     * @param string $paramName Имя параметра
     * @return string|null Значение параметра или null
     */
    public function getUtmParam(string $paramName): ?string
    {
        $value = request()->get($paramName);
        if (empty($value)) {
            $value = request()->cookie($paramName);
        }

        return $value ?: null;
    }

    /**
     * Регистрирует Blade директиву для использования в шаблонах
     */
    public static function registerBladeDirective(): void
    {
        Blade::directive('linkWithUTM', fn($expression) => 
            sprintf('<?php echo resolve(%s::class)->linkWithUTM(%s); ?>', self::class, $expression)
        );
    }
}
