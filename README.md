# Start migration
php artisan migrate:logger

# Start seeds
php artisan seed:action-logs
php artisan seed:test-logs

## Publish config
```
php artisan vendor:publish --provider="LaravelLogger\Providers\LoggerServiceProvider" --tag="logger-config"
php artisan vendor:publish --tag=logger-config
```
