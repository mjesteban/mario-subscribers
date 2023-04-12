<?php

namespace App\Services\MailerLite;

use App\Services\MailerLite\Endpoints\Subscriber;

class Client
{
    protected string $url = 'https://connect.mailerlite.com/';
    protected string $contentType = 'application/json';
    protected string $accept = 'application/json';

    protected string $apiKey = '';
    protected string $authorization = '';
    protected int $rateLimit = 120;
    protected string $httpMethod = 'get';
    protected array $queryParams = [];

    public function __construct()
    {
        $this->subscribers = new Subscriber($this);
    }
}