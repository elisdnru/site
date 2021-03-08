<?php

namespace tests\Helper;

use Codeception\Module;
use GuzzleHttp\Client;

class Acceptance extends Module
{
    public function dontHaveEmails(): void
    {
        $this->getMailerClient()->delete('/api/v1/messages');
    }

    public function seeEmailSentTo(string $to): void
    {
        $client = $this->getMailerClient();
        $response = $client->get('/api/v2/search?' . http_build_query(['kind' => 'to', 'query' => $to]));
        /** @var array{total: int} $data */
        $data = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertGreaterThan(0, $data['total']);
    }

    private ?Client $client = null;

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
