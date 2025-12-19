<?php

namespace Payroc\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Payroc\PayrocClient;
use Payroc\Environments;
use GuzzleHttp\Client;

abstract class IntegrationTestCase extends TestCase
{
    protected static PayrocClient $paymentsClient;
    protected static PayrocClient $genericClient;
    protected static string $terminalIdAvs;
    protected static string $terminalIdNoAvs;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $httpClient = new Client([
            'verify' => false,
        ]);

        self::$paymentsClient = new PayrocClient(
            apiKey: self::getEnv('PAYROC_API_KEY_PAYMENTS'),
            environment: Environments::Uat(),
            options: ['client' => $httpClient]
        );

        self::$genericClient = new PayrocClient(
            apiKey: self::getEnv('PAYROC_API_KEY_GENERIC'),
            environment: Environments::Uat(),
            options: ['client' => $httpClient]
        );

        self::$terminalIdAvs = self::getEnv('TERMINAL_ID_AVS');
        self::$terminalIdNoAvs = self::getEnv('TERMINAL_ID_NO_AVS');
    }

    private static function getEnv(string $name): string
    {
        $value = getenv($name);
        if ($value === false) {
            throw new \RuntimeException("Environment variable '{$name}' is not set.");
        }
        return $value;
    }
}
