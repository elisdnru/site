<?php

declare(strict_types=1);

namespace tests;

use Codeception\Actor;

final class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

    public function amLoggedInByAdmin(): void
    {
        $I = $this;

        $I->setCookie('_identity', $this->encodeCookie('_identity', $this->generateIdentity(1, '')));
    }

    public function amLoggedInByUser(): void
    {
        $I = $this;
        $I->setCookie('_identity', $this->encodeCookie('_identity', $this->generateIdentity(2, '')));
    }

    public function amLoggedInBy(int $id): void
    {
        $I = $this;
        $I->setCookie('_identity', $this->encodeCookie('_identity', $this->generateIdentity($id, '')));
    }

    private function encodeCookie(string $name, string $value): string
    {
        $data = serialize([$name, $value]);
        $hash = hash_hmac('sha256', $data, 'test', false);
        return $hash . $data;
    }

    private function generateIdentity(int $userId, string $authKey): string
    {
        return json_encode(
            [$userId, $authKey, 0],
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}
