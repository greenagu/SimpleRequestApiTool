<?php
namespace Libraries;

class Curl
{
    private static $ch = null;
    private static $chInfo = null;

    const GET       = 'GET';
    const POST      = 'POST';
    const PUT       = 'PUT';
    const DELETE    = 'DELETE';

    public static function get($url, $data = [], $options = [])
    {
        return self::execute($url, $data, self::GET, $options);
    }

    public static function post($url, $data = [], $options = [])
    {
        return self::execute($url, (is_object($data) || is_array($data)) ? http_build_query($data) : $data, self::POST, $options);
    }

    public static function put($url, $data = [], $options = [])
    {
        return self::execute($url, (is_object($data) || is_array($data)) ? http_build_query($data) : $data, self::PUT, $options);
    }

    public static function delete($url, $data = [], $options = [])
    {
        return self::execute($url, (is_object($data) || is_array($data)) ? http_build_query($data) : $data, self::DELETE, $options);
    }

    public static function execute($url, $data = '', $method = self::GET, $options = [])
    {
        $beginTime = microtime();
        self::$ch = curl_init();

        switch ($method) {
            default :
            case self::GET :
                $convertedData = ((!empty($data) && is_array($data)) ? '?'.http_build_query($data) : '');
                curl_setopt(self::$ch, CURLOPT_URL, "{$url}{$convertedData}");
                break;
            case self::POST :
                curl_setopt(self::$ch, CURLOPT_URL, "{$url}");
                curl_setopt(self::$ch, CURLOPT_POST, true);
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt(self::$ch, CURLOPT_SSL_VERIFYPEER, false);
                break;
            case self::PUT :
                curl_setopt(self::$ch, CURLOPT_URL, "{$url}");
                curl_setopt(self::$ch, CURLOPT_POST, true);
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, "PUT");
                break;
            case self::DELETE :
                curl_setopt(self::$ch, CURLOPT_URL, "{$url}");
                curl_setopt(self::$ch, CURLOPT_POST, true);
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt(self::$ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }

        curl_setopt(self::$ch, CURLOPT_TIMEOUT, 0);
        curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, true);

        if (count($options)) {
            foreach ($options as $key => $value) {
                curl_setopt(self::$ch, $key, $value);
            }
        }

        $result = curl_exec(self::$ch);
        if (!$result) {
            echo '[ERROR] Curl error :: ' . curl_error(self::$ch). PHP_EOL;
        }

        self::$chInfo = curl_getInfo(self::$ch);

        curl_close(self::$ch);
        $endTime = microtime();
        // echo 'curl excute time : '. $beginTime-$endTime. PHP_EOL;

        return $result;
    }

    public static function getInfo()
    {
        return self::$chInfo;
    }
}
