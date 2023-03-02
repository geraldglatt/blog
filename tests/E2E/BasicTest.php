<?php

namespace App\Tests\E2E;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client;


class BasicTest extends PantherTestCase
{
    public function TestEnvironmentIsOk(): void
    {
        $client = Client::createChromeClient(null,[
            'browser' => PantherTestCase::CHROME
        ]);

        $client->request(method: 'GET', uri: '/' );
        $this->assertSelectorExists(selector: 'h1');
        $this->assertSelectorTextContains(selector: 'h1', text: 'Blog');
    }
}