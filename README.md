<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

#BookMarks

## How to Install

- git clone THIS_REPO
- cp .env.example .env
- composer install
- php artisan key:generate
- create empty DB and config it into .env
- php artisan migrate
- `cd /var/www/THIS_SITE/html/` AND `cp -R storage ../`
- php artisan storage:link

```
sudo chmod -R 777 /var/www/THIS_SITE/{\
storage/framework/cache,\
storage/framework/views,\
storage/framework/sessions,\
html/bootstrap/cache}
```

## Высокопроизводительный поиск
Рассчитан на количество записей в БД до 100 000 в условиях высокой нагрузки  

Для Scout + Algolia не забудьте установить ваши ALGOLIA_APP_ID и ALGOLIA_SECRET в файл .env  

Если вы уже установили Scout тогда можно добавить вашу модель в поисковой индекс:  
```
php artisan scout:import "App\Bookmark"
```
Чтобы удалить все записи модели из поискового индекса выполните:
```
php artisan scout:flush "App\Bookmark"
```
Так же выполните другие инструкции по адресу: 
https://laravel.com/docs/7.x/scout  

### Как настроить Laravel Scout + Elasticsearch driver ?
- Установите куда-нибудь сервер эластика с помощью докера:
```
docker pull docker.elastic.co/elasticsearch/elasticsearch:7.6.2  
docker run -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:7.6.2  
```

- Прописать адрес сервера эластика в .env файл:      
    `SCOUT_ELASTIC_HOST=88.44.55.99:9200`

- Установить Elasticsearch driver по инструкции: https://github.com/babenkoivan/scout-elasticsearch-driver

- Если обновились настройки схемы данных для поиска, тогда выполните:  
`php artisan elastic:update-mapping "App\Bookmark"`
- Для создания конфигуратора индекса выполните:  
`php artisan elastic:create-index "App\BookmarkIndexConfigurator"`
- Для отправки индекса на сервер эластика выполните:  
`php artisan scout:import "App\Bookmark"`

## CI/CD fix:
- create the symbolic link in public directory:  
```php artisan storage:link```
- copy storage to outer project directory:  
```cp -R storage ../```
- add code fix to bootstrap/app.php file (for using outer project storage):
```
if (!function_exists('locateBasePath')) {
    /**
     * @param $app
     * @return string
     */
    function locateBasePath($app)
    {
        $underBuild = realpath($app->basePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'storage');
        $inBuild = realpath($app->basePath() . DIRECTORY_SEPARATOR . 'storage');

        if (is_dir($underBuild))
            return $underBuild;
        else
            return $inBuild;
    }
}
$app->useStoragePath(locateBasePath($app));
```

#### Other
Чтобы создать фабрики, миграции, модели и resource контроллер выполните:
```
php artisan make:model Bookmark -a
```
Чтобы нагенерировать фейковых закладок:
```
php artisan tinker
factory(App\Bookmark::class, 3)->create(); 
```
