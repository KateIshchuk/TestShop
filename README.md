
## 📦 Технології

| Технологія              | Опис                                          |
|-------------------------|-----------------------------------------------|
| **Laravel 12**          | PHP-фреймворк                                 |
| **Laravel Sail**        | Docker-оточення для Laravel                   |
| **Livewire 3**          | Динамічний фронтенд без JS-фреймворків        |
| **Filament 3**          | Сучасна адмін-панель для Laravel              | 
| **Spatie MediaLibrary** | Зберігання медіа (фото товарів, галереї тощо) |


## Для запуску проекту 

### 1) Клонуємо репозиторій
### 2) Скопіювати .env.example в .env і запустити 

`./vendor/bin/sail build  
./vendor/bin/sail up -d
./vendor/bin/sail composer install`

### 3) Запустити наступні команди

`./vendor/bin/sail artisan key:generate  
./vendor/bin/sail artisan migrate --seed`

### 4) Перейти за адресою:
#### Фронтенд: http://localhost
#### Адмін-панель: http://localhost/admin

## Дані для входу в адмінку
**Email**: test@example.com
**Пароль**: adminadmin
