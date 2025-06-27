<?php

declare(strict_types=1);

namespace tests\Module;

use Codeception\Module;
use GuzzleHttp\Client;

/**
 * @psalm-api
 */
final class Mailer extends Module
{
    private ?Client $client = null;

    public function dontHaveEmails(): void
    {
        $this->getMailerClient()->delete('/api/v1/messages');
    }

    public function seeEmailSentTo(string $to): void
    {
        $client = $this->getMailerClient();
        $response = $client->get('/api/v1/search?' . http_build_query(['query' => 'to:' . $to]));
        /** @var array{total: int} $data */
        $data = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertGreaterThan(0, $data['total']);
    }

    private function getMailerClient(): Client
    {
        if ($this->client === null) {
            $this->client = new Client([
                'base_uri' => 'http://site-mailer:8025',
            ]);
        }
        return $this->client;
    }
}
