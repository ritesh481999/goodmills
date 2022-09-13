<?php

namespace App\Utils;

use Request;

class ApiResponseBuilder
{

    private $header;
    private $body;
    private $httpStatus = 200;
    private static $serviceName;

    public function __construct()
    {
        if (!self::hasServiceName())
            self::setServiceName();

        $this->header = [
            'version' => config('common.api_version'),
            'serviceName' => self::$serviceName,
            'timestamp' => now()->toDateTimeString(),
        ];
        $this->body = [
            'status' => false,
            'msg' => null
        ];
    }

    public function setVersion(string $version): self
    {
        $this->header['version'] = $version;
    }

    public function setMessage(string $message): self
    {
        $this->body['msg'] = $message;
        return $this;
    }

    public function setData(array $data = null): self
    {
        $this->body['data'] = $data;
        return $this;
    }

    public function addBody(array $body = null): self
    {
        $this->body = array_merge($this->body, $body);
        return $this;
    }

    public function addHeader(array $header = null): self
    {
        $this->header = array_merge($this->header, $header);
        return $this;
    }

    public function setHttpStatus(int $status = 200): self
    {
        $this->httpStatus = $status;
        return $this;
    }

    public function setStatus(bool $status = true): self
    {
        $this->body['status'] = $status;
        return $this;
    }

    public function get()
    {
        $res = [
            'APIService' => [
                'header' => $this->header,
                'body' => $this->body
            ]
        ];
        return response()->json($res, $this->httpStatus);
    }

    static public function make(string $message, array $data = null, bool $status = true, int $httpStatus = 200): self
    {
        $m = new self;
        $m->setMessage($message)
            ->setStatus($status)
            ->setHttpStatus($httpStatus);
        if ($data !== null)
            $m->setData($data);

        return $m;
    }

    static private function hasServiceName(): bool
    {
        return !empty(self::$serviceName);
    }

    static public function setServiceName(string $name = null): void
    {
        self::$serviceName = $name ?? self::guessServiceName();
    }

    static public function guessServiceName()
    {
        $route_name = Request::route()->getName();
        return str_replace('api.', '', $route_name);
    }
}
