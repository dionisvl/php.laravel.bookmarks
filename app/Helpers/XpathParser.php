<?php

namespace App\Helpers;

use DOMDocument;

/**
 * Парсер сайтов Xpath
 * Class XpathParser
 * @package App\Helpers
 */
class XpathParser
{
    public $xml;
    public $bookmark_url;
    private $domain_url;

    /**
     * PageParser constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->bookmark_url = $bookmark_url = $this->getRightSiteUrl($url);
//        dd($this->bookmark_url);

        $domain_url = parse_url($bookmark_url);
        $scheme = empty($domain_url['scheme']) ? '' : $domain_url['scheme'] . '://';
        $this->domain_url = $scheme . $domain_url['host'];
        //dd($this->domain_url);


        $doc = new DOMDocument();
        $doc->strictErrorChecking = false;
        libxml_use_internal_errors(false);
//        dd($url);
        @$doc->loadHTML(file_get_contents($bookmark_url));
        $this->xml = simplexml_import_dom($doc);

        $this->url = $bookmark_url;
    }

    /**
     * Преобразуем адрес сайта в правильный,
     * например ya.ru => https://ya.ru/
     * @param $url
     * @return string
     */
    private function getRightSiteUrl($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //set url
        curl_setopt($ch, CURLOPT_HEADER, true); //get header
        curl_setopt($ch, CURLOPT_NOBODY, true); //do not include response body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //do not show in browser the response
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //follow any redirects
        curl_exec($ch);

        return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);//extract the url from the header response
    }

    /**
     * Получим любой объект из DOM Дерева по Xpath
     * @param string $path
     * @param string $field
     * @return string
     */
    public function get(string $path, string $field = ''): string
    {
        $query = $this->xml->xpath($path);
        if ($field) {
            return $query[0][$field] ?? '';
        } else {
            return $query[0] ?? '';
        }
    }

    /**
     * Обработаем картинку, если она хранится относительной ссылкой, сделаем абсолютную.
     * @param string $file_link
     * @return string
     */
    public function getLink(string $file_link): string
    {

        if (empty($file_link))
            return '';

        if ($this->fileExists($file_link)) {
            return $file_link;
        }

        if ($this->fileExists($this->domain_url . $file_link)) {
            return $this->domain_url . $file_link;
        }

        $right_link = $this->getRightLink($file_link);
        if ($this->fileExists($right_link)) {
            return $right_link;
        }

        return '';
    }

    /**
     * Проверим существует ли этот файл, не загружая его, а только прочитав ответ сервера
     * @param string $url
     * @return bool
     */
    private function fileExists(string $url): bool
    {
        $curl = curl_init($url);
        //don't fetch the actual page, you only want to check the connection is ok
        curl_setopt($curl, CURLOPT_NOBODY, true);
        //do request
        $result = curl_exec($curl);
        $ret = false;
        //if request did not fail
        if ($result !== false) {
            //if request was ok, check response code
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 200) {
                $ret = true;
            }
        }
        curl_close($curl);
        if ($ret) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Преобразуем адрес файла в корректный,
     * например
     *   //yastatic.net/iconostasis/_/8lFaTHLDzmsEZz-5XaQg9iTWZGE.png
     *  =>
     *  https://yastatic.net/iconostasis/_/8lFaTHLDzmsEZz-5XaQg9iTWZGE.png
     * @param $url
     * @return string
     */
    private function getRightLink($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        if (preg_match('~Request URL: (.*)~i', $result, $match)) {
            $request_url = trim($match[1]);
        }
        return $request_url ?? '';
    }

}
