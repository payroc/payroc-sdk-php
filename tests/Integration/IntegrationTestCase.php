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

        $environment = self::getCustomEnvironment();

        self::$paymentsClient = new PayrocClient(
            apiKey: self::getEnv('PAYROC_API_KEY_PAYMENTS'),
            environment: $environment,
            options: ['client' => $httpClient]
        );

        self::$genericClient = new PayrocClient(
            apiKey: self::getEnv('PAYROC_API_KEY_GENERIC'),
            environment: $environment,
            options: ['client' => $httpClient]
        );

        self::$terminalIdAvs = self::getEnv('TERMINAL_ID_AVS');
        self::$terminalIdNoAvs = self::getEnv('TERMINAL_ID_NO_AVS');
    }

    private static function getCustomEnvironment(): Environments
    {
        $apiBaseUrl = getenv('PAYROC_API_BASE_URL');
        $identityBaseUrl = getenv('PAYROC_IDENTITY_BASE_URL');

        // If custom URLs are provided, use them
        if ($apiBaseUrl !== false && $apiBaseUrl !== '' && $identityBaseUrl !== false && $identityBaseUrl !== '') {
            return Environments::custom($apiBaseUrl, $identityBaseUrl);
        }

        // Otherwise, fall back to UAT
        return Environments::Uat();
    }

    private static function getEnv(string $name): string
    {
        $value = getenv($name);
        if ($value === false || $value === '') {
            if (str_starts_with($name, 'PAYROC_API_KEY_')) {
                $fallbackValue = getenv('PAYROC_API_KEY');
                if ($fallbackValue !== false && $fallbackValue !== '') {
                    return $fallbackValue;
                }
            }
            throw new \RuntimeException("Environment variable '{$name}' is not set.");
        }
        return $value;
    }
}
