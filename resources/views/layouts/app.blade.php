<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    @seo

    @vite(['resources/js/app.js'])

    @stack('scripts')
</head>

<body>

    @include('layouts.navigation')

    <main data-bs-spy="scroll">
        {{ $slot }}
    </main>

    @include('layouts.footer')

    @stack('metrics')

    @production
        <!— Yandex.Metrika counter —>
            <script type="text/javascript">
                (function(m, e, t, r, i, k, a) {
                    m[i] = m[i] || function() {
                        (m[i].a = m[i].a || []).push(arguments)
                    };
                    m[i].l = 1 * new Date();
                    for (var j = 0; j < document.scripts.length; j++) {
                        if (document.scripts[j].src === r) {
                            return;
                        }
                    }
                    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
                        k, a)
                })
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

                ym(97281013, "init", {
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            </script>
            <noscript>
                <div><img src="https://mc.yandex.ru/watch/97281013" style="position:absolute; left:-9999px;"
                        alt="" /></div>
            </noscript>
            <!— /Yandex.Metrika counter —>

            <script type="text/javascript">
                ! function() {
                    var t = document.createElement("script");
                    t.type = "text/javascript", t.async = !0, t.src = 'https://vk.com/js/api/openapi.js?172', t.onload =
                        function() {
                            VK.Retargeting.Init("VK-RTRG-1873047-Mn1s"), VK.Retargeting.Hit()
                        }, document.head.appendChild(t)
                }();
            </script>
            <noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1873047-Mn1s" style="position:fixed; left:-999px;" alt="" /></noscript>

            @endproduction

</body>

</html>
