<?php

namespace Tests\Feature;

use App\Services\MailerLite\MailerLiteApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MailerLiteApiTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // Seed the api_keys table with a fake API key

        DB::table('api_keys')->insert([
            'id' => 1,
            'key' => 'fake-api-key',
        ]);
    }

    public function test_getSubscribers_method_returns_valid_response()
    {
        // Mock a successful response from the API
        Http::fake([
            'connect.mailerlite.com/api/subscribers/*' => Http::response(
                [
                    'data' => [
                        [
                            'email' => 'jane.doe@example.com',
                            'name' => 'Jane',
                            'last_name' => 'Doe',
                            'country' => 'US',
                        ],
                        [
                            'email' => 'john.doe@example.com',
                            'name' => 'John',
                            'last_name' => 'Doe',
                            'country' => 'CA',
                        ],
                    ],
                    'total' => 2,
                ],
                200,
            ),
        ]);

        // Create a new instance of the MailerLiteApi class
        $mailerLiteApi = new MailerLiteApi();

        // Call the getSubscribers method with a limit of 2
        $response = $mailerLiteApi->getSubscribers(2);

        // Assert that the response has the correct keys and values
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('total', $response);
        $this->assertCount(2, $response['data']);
        $this->assertEquals(
            'jane.doe@example.com',
            $response['data'][0]['email'],
        );
        $this->assertEquals('US', $response['data'][0]['country']);
        $this->assertEquals(
            'john.doe@example.com',
            $response['data'][1]['email'],
        );
        $this->assertEquals('CA', $response['data'][1]['country']);
    }

    public function test_storeSubscriber_method_returns_valid_response()
    {
        // Mock a successful response from the API
        Http::fake([
            'connect.mailerlite.com/api/subscribers' => Http::response(
                null,
                201,
            ),
        ]);

        // Create a new instance of the MailerLiteApi class
        $mailerLiteApi = new MailerLiteApi();

        // Call the storeSubscriber method with some sample data
        $response = $mailerLiteApi->storeSubscriber([
            'email' => 'jane.doe@example.com',
            'name' => 'Jane',
            'last_name' => 'Doe',
            'country' => 'US',
        ]);

        // Assert that the response has the correct keys and values
        $this->assertArrayHasKey('state', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('success', $response['state']);
        $this->assertEquals('New subscriber added.', $response['message']);
    }
}