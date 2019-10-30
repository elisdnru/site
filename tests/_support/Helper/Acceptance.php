<?php

namespace tests\Helper;

use GuzzleHttp\Client;

class Acceptance extends \Codeception\Module
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _beforeSuite($settings = []): void
    {
        $this->getMailerClient()->delete('/api/v1/messages');
    }

    public function seeEmailSentTo(string $to): void
    {
        $client = $this->getMailerClient();
        $response = $client->get('/api/v2/search?' . http_build_query(['kind' => 'to', 'query' => $to]));
        $data = json_decode($response->getBody()->getContents(), true, 512);
        $this->assertGreaterThan(0, $data['total']);
    }

    private $client;

    private function getMailerClient(): Client
    {
        if ($this->client === null) {
            $this->client = new Client([
                'base_uri' => 'http://mailer:8025'
            ]);
        }
        return $this->client;
    }
}
