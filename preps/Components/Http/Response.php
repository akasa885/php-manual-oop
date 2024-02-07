<?php

namespace Preps\Components\Http;

class Response
{

    protected $content;

    protected $status;

    protected $headers;

    protected $statusText;

    protected static $statusTexts;

    public function __construct($content = '', $status = 200, $headers = [])
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }

        foreach ($this->headers as $name => $values) {
            $replace = 0 === strcasecmp($name, 'Content-Type');
            foreach ($values as $value) {
                header($name . ': ' . $value, $replace, $this->status);
            }
        }

        header('HTTP/1.1 ' . $this->status);

        return $this;
    }

    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setStatusCode($code, $text = null)
    {
        $this->status = $code;

        if (null === $text) {
            $this->statusText = isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '';
        } else {
            $this->statusText = $text;
        }

        return $this;
    }

    public function setHeader($name, $value, $replace = true)
    {
        $this->headers[$name] = [$value];

        return $this;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function redirect($url, $status = 302)
    {
        $this->setStatusCode($status);
        $this->setHeader('Location', $url);

        return $this;
    }

    public function json($data, $status = 200, $headers = [])
    {
        $this->setHeader('Content-Type', 'application/json');

        return $this->setContent(json_encode($data));
    }
}
