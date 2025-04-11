<?php
class BaseController
{
    public function __call($name, $arguments)
    {
        $this->sendOutput('', ['HTTP/1.1 404 Not Found']);
    }

    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri;
    }

    protected function getQueryStringParams()
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }

    protected function getRequestData()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    protected function sendOutput($data, $httpHeaders = [])
    {
        // Allow requests from any frontend
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    
        header_remove('Set-Cookie');
    
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
    
        echo $data;
        exit;
    }
    
}