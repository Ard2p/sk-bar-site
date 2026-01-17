<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveUtmParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Список UTM параметров для сохранения
        $utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        
        // Проверяем наличие UTM параметров в запросе
        $hasUtmParams = false;
        foreach ($utmParams as $param) {
            if ($request->has($param)) {
                $hasUtmParams = true;
                break;
            }
        }
        
        // Если есть UTM параметры в запросе, сохраняем их в cookies
        if ($hasUtmParams) {
            foreach ($utmParams as $param) {
                if ($request->has($param)) {
                    // Сохраняем cookie на 30 дней
                    cookie()->queue(cookie($param, $request->get($param), 60 * 24 * 30));
                }
            }
        }
        
        return $next($request);
    }
}
