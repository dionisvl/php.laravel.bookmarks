<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

#BookMarks


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
