<?php
namespace Libraries;

require_once __DIR__.'/Curl.php';

class RequestAPI {
    private $method;
    private $requestUri;
    private $requestParam;
    private $contentType;
    private $userAgent;
    private $options = [];
    private $headers = [];

    const AUTH_KEY = "ZGFvdUhvbWV3b3JrOmFkbWluOmF1dGhLZXk=";

    function __construct($key) {
        $this->isValid($key);
    }

    public function setMethod($method) 
    {
        $this->method = $method;
    }

    public function setRequestUri($uri) 
    {
        $this->requestUri = $uri;
    }

    public function setRequestParam($param = []) {
        $this->requestParam = $param;
    }

    public function getUserAgent() : string
    {
        //인증할때 user-Agent를 이용하고자 한다면 형식을 맞춰야 한다
        if (is_null($this->userAgent) || empty($this->userAgent)) {
            $this->userAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36";
        }
        return $this->userAgent;
    }
    public function setUserAgent(string $userAgent)
    {
        $this->userAgent = $userAgent;
    }

    public function getContentType()
    {
        if (is_null($this->contentType) || empty($this->contentType)) {
            $this->contentType= 'application/x-www-form-urlencoded; charset=utf-8';
        }
        return $this->contentType;
    }
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
    }

    public function setHeaders($headerStr = '') {
        $this->headers = explode(",", $headerStr);
    }
    public function getHeaders() {
        return $this->headers;
    }

    public function getOptions() : array
    {
        $header = array_merge($this->headers, [
            'SITE_AUTH:'.self::AUTH_KEY
            , 'User-Agent:'.$this->getUserAgent()
            , 'Content-Type:'.$this->getContentType()
        ]);

        $_opt = [ CURLOPT_HTTPHEADER => $header ];

        if (count($this->options)) {
            foreach ($this->options as $key => $value) {
                $_opt[$key] = $value;
            }
        }
        return $_opt;
    }
    public function setOptions($options)
    {
        if (!empty($options)) {
            $this->options = array_reduce(explode(",", $options), function($acc, $opt) {
                $optArr = explode(":", $opt);
                if (!empty($optArr[0])) {
                    $acc[$optArr[0]] = $optArr[1] ?? "";
                }
                return $acc;
            }, []);
        }
    }

    public function callApi() {
        $result = false;
        echo "options ::: ".var_export($this->getOptions()). PHP_EOL;
        if (in_array($this->method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            $data = empty($this->requestParam) ? null : $this->requestParam;
            switch ($this->method) {
                case 'GET':
                    $data = empty($this->requestParam) ? null : '?'.http_build_query($this->requestParam);
                    $result = Curl::get($this->requestUri.$data, null, $this->getOptions());
                    break;
                case 'POST':
                    $result = Curl::post($this->requestUri, $data, $this->getOptions());
                    break;
                case 'PUT':
                    $result = Curl::put($this->requestUri, $data, $this->getOptions());
                    break;
                case 'DELETE':
                    $result = Curl::delete($this->requestUri, $data, $this->getOptions());
                    break;
            }

        } else {
            throw new \Exception("Invalid HTTP method: {$this->method}");
        }

        if (!$result) {
            throw new \Exception("The requested call failed.");
            exit;
        }
    }

    private function isValid($key)
    {
        if (self::AUTH_KEY != $key) {
            throw new \Exception("Invalid auth key");
        }
    }
}