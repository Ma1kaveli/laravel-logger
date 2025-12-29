# Laravel Logger

**Laravel Logger** — это пакет для Laravel, предоставляющий расширенные возможности логирования действий пользователей. Он позволяет записывать успешные и неуспешные действия с использованием slug'ов, поддерживает фильтрацию логов и асинхронное логирование через очереди.

## Возможности

- Логирование успешных и неуспешных действий с использованием slug'ов.
- Поддержка асинхронного логирования через очереди Laravel.
- Фильтрация логов по дате, пользователю, организации и другим параметрам.
- Консольные команды для создания тестовых данных и выполнения миграций.
- Настраиваемые префиксы для успешных и неуспешных действий.

## Требования

- PHP 8.2 или выше
- Laravel 10.10, 11.0 или 12.0
- Пакет `makaveli/laravel-query-builder` (версия 1.1.0)
- Пакет `makaveli/laravel-core` (версия 1.0.0)

## Установка

1. Установите пакет через Composer:

   ```bash
   composer require makaveli/laravel-logger
   ```

2. (Опционально) Опубликуйте файл конфигурации:

   ```bash
   php artisan vendor:publish --tag=logger-config
   ```

   Файл конфигурации будет скопирован в `config/logger.php`, где вы сможете настроить параметры, такие как модель пользователя или поддержку организаций.

3. Выполните миграции пакета:

   ```bash
   php artisan migrate:logger
   ```

   Это создаст схему `logs` и таблицы `logs.action_logs` и `logs.logs` в вашей базе данных.

## Конфигурация

Файл конфигурации `config/logger.php` позволяет настроить следующие параметры:

- **`success_prefix`**: Префикс для slug'ов успешных действий (по умолчанию: `'success'`).
- **`error_prefix`**: Префикс для slug'ов неуспешных действий (по умолчанию: `'error'`).
- **`user_model`**: Путь к модели пользователя (по умолчанию: `App\Models\User::class`).
- **`user_resource`**: Класс ресурса для форматирования данных пользователя (по умолчанию: `[\App\Modules\Base\Resources\UserShortResource::class, 'once']`).
- **`slug_list`**: Массив slug'ов для создания action logs через сиды (по умолчанию: пустой массив).
- **`logs_factory_count`**: Количество тестовых логов для создания через сиды (по умолчанию: `1000`).

Пример конфигурации:

```php
return [
    'success_prefix' => 'success',
    'error_prefix' => 'error',
    'user_model' => App\Models\User::class,
    'user_resource' => [\App\Modules\Base\Resources\UserShortResource::class, 'once'],
    'slug_list' => [
        ['name' => 'User Login', 'slug' => 'user.login'],
        ['name' => 'User Logout', 'slug' => 'user.logout'],
    ],
    'repository' => [
        'description_callback' => function (\Illuminate\Contracts\Auth\Authenticatable $user, Logger\Models\ActionLog $log) {
            return strtoupper($user->name) . ' did: ' . $log->name;
        }
    ],
    'logs_factory_count' => env('LOG_FACTORY', 1000),
];
```

## Использование

### Запись логов

Для записи логов используйте трейт `Logger`:

- **`successLog(string $slug)`**: Записывает лог для успешного действия.
- **`errorLog(string $slug, ?string $error = null)`**: Записывает лог для неуспешного действия с опциональным описанием ошибки.
- **`softMethodLogger(string $slug, array $data)`**: Используется для методов удаления/восстановления, где `$data` содержит код и сообщение.

Пример использования в контроллере:

```php
use Logger\Traits\Logger;

class UserController extends Controller
{
    use Logger;

    public function login(Request $request)
    {
        if ($loginSuccess) {
            $this->successLog('user.login');
        } else {
            $this->errorLog('user.login', 'Invalid credentials!');
        }
    }

    public function delete($id)
    {
        $this->softMethodLogger('user.delete', ['code' => 200]);
        $this->softMethodLogger('user.delete', ['message' => 'Invalid credentials!', 'code' => 400]);
    }
}
```

Для асинхронной записи используйте трейт `AsyncLogger`:

- **`successAsyncLog(string $slug)`**
- **`errorAsyncLog(string $slug, ?string $error = null)`**
- **`softMethodAsyncLogger(string $slug, array $data)`**

Эти методы отправляют задачи в очередь для фоновой обработки.

### Получение логов

Для получения логов используйте репозиторий `LogRepository`:

```php
use Logger\Repositories\LogRepository;

$logRepository = new LogRepository();
$logs = $logRepository->getCustomPaginatedList($dto, 'users');
```

Где `$dto` — объект `ActionLogShowDTO`, содержащий параметры фильтрации, а `'users'` указывает тип фильтрации (по пользователям или организациям).

### Фильтрация логов

Класс `ActionLogShowDTO` поддерживает фильтрацию по следующим параметрам:

- `dateFrom` и `dateTo`: Фильтр по диапазону дат.
- `userId`: Фильтр по ID пользователя.
- `organizationId`: Фильтр по ID организации.
- `actionLogId`: Фильтр по ID action log.
- `search`: Поиск по полям пользователя (имя, телефон, email и т.д.).

Пример фильтрации:

```php
use Logger\DTO\ActionLogShowDTO;

$dto = ActionLogShowDTO::fromRequest($request, $actionLogId);
```

## Консольные команды

### Создание action logs

Для создания action logs на основе slug'ов из конфигурации:

```bash
php artisan seed:action-logs
```

### Создание тестовых логов

Для заполнения базы тестовыми логами:

```bash
php artisan seed:test-logs
```

Количество логов определяется параметром `logs_factory_count`.

### Выполнение миграций

Для запуска миграций пакета:

```bash
php artisan migrate:logger
```

## Настройка и расширение

### Трансформеры

В `ActionLogShowDTO` можно передать callable-функции для валидации `userId` и `organizationId`, чтобы ограничить доступ к данным:

```php
$dto = ActionLogShowDTO::fromRequest($request, $id, fn($user, $id) => $user->id === $id);
```

### Ресурс пользователя

По умолчанию используется `UserShortResource`. Вы можете указать собственный класс:

```php
'user_resource' => [\App\Resources\UserResource::class, 'once'],
```

## Схема базы данных

Пакет создаёт схему `logs` и две таблицы:

- **`logs.action_logs`**:
  - `id`: Первичный ключ.
  - `name`: Название действия.
  - `slug`: Уникальный slug действия.
  - `description`: Описание действия.
  - `created_at` и `updated_at`: Временные метки.

- **`logs.logs`**:
  - `id`: Первичный ключ.
  - `created_by`: ID пользователя, выполнившего действие.
  - `action_log_id`: ID action log.
  - `error_description`: Описание ошибки (если есть).
  - `description`: Описание действия.
  - `is_error`: Флаг ошибки.
  - `created_at` и `updated_at`: Временные метки.

## Расширение пакета

Вы можете переопределить:

- Модели `ActionLog` и `Log`.
- Класс `LogFilters` для изменения логики фильтрации.
- Ресурсы `LogResource` и `ActionLogResource` для настройки формата данных.
