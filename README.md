# Telegram Helper
- This package help us send log to Telegram channel through a bot chat and it runs with Job in Laravel framework.
## 1. Requirement and install
- PHP >=7.0
```bash
composer require huyct/telegram-helper
```
- Add this line to `bootstrap/providers.php` in laravel >=11.0 and in `config/app.php` in lower version.
```php
\Huyct\TelegramHelper\providers\TelegramHelperProvider::class,
```
- Publish config
```bash
php artisan vendor:publish --tag=telegramhelper
# Position of file config: config/telegramhelper.php
```
- Add these lines to `.env`
```dotenv
TELEGRAM_BOT_TOKEN=
TELEGRAM_CHANNEL_LOG_ID=    
TELEGRAM_CHANNEL_ERROR_ID=
// these lines if you lack
HELPER_LOG_DRIVER=telegram
HELPER_LOG_ENABLE=true
HELPER_LOG_QUEUE_NAME=send-log
```