<?php

namespace App\Services\MailerLite;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MailerLiteApi
{
    public const SUCCESS = 'success';
    public const FAILED = 'danger';
    protected const UNEXPECTED_ERROR = 'An unexpected error occurred. Please try again.';

    protected string $table = 'api_keys';
    protected string $column = 'key';

    protected ?string $apiKey = null;

    public function __construct()
    {
        $this->apiKey = DB::table($this->table)
            ->select($this->column)
            ->value($this->column);
    }

    public function request(
        string $httpMethod = 'get',
        array $queryParams = [],
        ?string $resource = null
    ) {
        $apiKey = $this->apiKey;

        return Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->$httpMethod(
            "https://connect.mailerlite.com/api/subscribers/$resource",
            $queryParams,
        );
    }

    public function getSubscribers(
        int $limit,
        ?string $emailContains = null
    ): array {
        $response = $this->request('get', ['limit' => $limit]);
        $json = $response->json();

        if ($response->failed()) {
            $json['data'] = [];
        } elseif (!empty($emailContains)) {
            $json['data'] = $this->filter($json['data'], $emailContains);
            $json['total_filtered'] = count($json['data']);
        }

        return $json;
    }

    public function filter(array $subscribers, string $emailSubstring): array
    {
        //Datatables will not render if not re-indexed
        return array_values(
            array_filter(
                $subscribers,
                static fn($subscriber) => strpos(
                    $subscriber['email'],
                    $emailSubstring,
                ) !== false,
            ),
        );
    }

    public function getTotalSubscribers(): int
    {
        $response = $this->request('get', ['limit' => 0]);

        return $response->successful() ? $response->json('total') : 1;
    }

    public function storeSubscriber(array $request): array
    {
        $response = $this->request('post', [
            'email' => $request['email'],
            'fields' => [
                'name' => $request['name'] ?? null,
                'last_name' => $request['last_name'] ?? null,
                'country' => $request['country'] ?? null,
            ],
        ]);

        $state = self::FAILED;
        $message = self::UNEXPECTED_ERROR;

        switch ($response->status()) {
            case 201:
                $state = self::SUCCESS;
                $message = 'New subscriber added.';
                break;
            case 200:
                $message = 'The email already exists.';
                break;
            default:
                if ($response->failed()) {
                    $message = $response->json('message');
                }
        }

        return compact('state', 'message');
    }

    public function getSubscriber(int $id): array
    {
        $response = $this->request('get', [], $id);

        if ($response->failed()) {
            $message =
                $response->status() === 404
                    ? 'Subscriber not found.'
                    : $response->json('message');

            return ['state' => self::FAILED, 'message' => $message];
        }

        return $response;
    }

    public function updateSubscriber(array $request, int $id): array
    {
        $response = $this->request(
            'put',
            [
                'fields' => [
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'country' => $request['country'],
                ],
            ],
            $id,
        );

        $message = self::UNEXPECTED_ERROR;
        $state = self::FAILED;

        if ($response->status() === 200) {
            return [
                'state' => self::SUCCESS,
                'message' => 'Edited Subscriber',
            ];
        }

        if ($response->failed()) {
            $message = $response->json('message');
        }

        return compact('state', 'message');
    }

    public static function storeApiKey(array $request): array
    {
        $value = $request['key'];

        if (self::ping($value)) {
            DB::table('api_keys')->updateOrInsert(
                ['id' => 1],
                ['key' => $value],
            );

            return ['state' => self::SUCCESS];
        }

        return [
            'state' => self::FAILED,
            'message' => 'MailerLite API did not find the key.',
        ];
    }

    public static function ping(string $apiKey): bool
    {
        return Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->get('https://connect.mailerlite.com/api/subscribers/?limit=0')
            ->successful();
    }

    public function deleteSubscriber(int $id)
    {
        return $this->request('delete', [], $id);
    }

    public function hasKey(): bool
    {
        return !empty($this->apiKey);
    }
}