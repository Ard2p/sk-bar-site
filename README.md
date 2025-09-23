## Запуск проекта

### Админка

-   Создать администратора
-   URL для входа https://site.ru/admin

### AI Генерация названий событий

Для работы AI-предложений названий событий добавьте в файл `.env`:

```
OPENROUTER_API_KEY=your_openrouter_api_key_here
OPENROUTER_API_URL=https://openrouter.ai/api/v1/chat/completions
OPENROUTER_MODEL=anthropic/claude-3.5-sonnet
```

Получить API ключ можно на [OpenRouter.ai](https://openrouter.ai/)

### Телеграм Бот

Для работы бота нужно установить вебхук на ваш домен

-   php artisan nutgram:hook:set https://site.ru/api/telegram/webhook
-   php artisan nutgram:hook:remove

### Схема бара

Использую инскейп
