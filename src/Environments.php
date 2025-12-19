<?php

namespace Payroc;

/**
 * Represents the available environments for the API with multiple base URLs.
 */
class Environments
{
    /**
     * @var string $api
     */
    public readonly string $api;

    /**
     * @var string $identity
     */
    public readonly string $identity;

    /**
     * @param string $api The api base URL
     * @param string $identity The identity base URL
     */
    private function __construct(
        string $api,
        string $identity,
    ) {
        $this->api = $api;
        $this->identity = $identity;
    }

    /**
     * Production environment
     *
     * @return Environments
     */
    public static function Production(): Environments
    {
        return new self(
            api: 'https://api.payroc.com/v1',
            identity: 'https://identity.payroc.com'
        );
    }

    /**
     * Uat environment
     *
     * @return Environments
     */
    public static function Uat(): Environments
    {
        return new self(
            api: 'https://api.uat.payroc.com/v1',
            identity: 'https://identity.uat.payroc.com'
        );
    }

    /**
     * Create a custom environment with your own URLs
     *
     * @param string $api The api base URL
     * @param string $identity The identity base URL
     * @return Environments
     */
    public static function custom(string $api, string $identity): Environments
    {
        return new self(
            api: $api,
            identity: $identity
        );
    }
}
