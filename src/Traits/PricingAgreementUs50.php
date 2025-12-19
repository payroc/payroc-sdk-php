<?php

namespace Payroc\Traits;

use Payroc\Types\PricingAgreementUs50Country;
use Payroc\Types\PricingAgreementUs50Version;
use Payroc\Types\BaseUs;
use Payroc\Types\PricingAgreementUs50Processor;
use Payroc\Types\GatewayUs50;
use Payroc\Types\ServiceUs50;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about U.S. pricing intents for Merchant Processing Agreement (MPA) 5.0.
 *
 * @property value-of<PricingAgreementUs50Country> $country
 * @property value-of<PricingAgreementUs50Version> $version
 * @property BaseUs $base
 * @property ?PricingAgreementUs50Processor $processor
 * @property ?GatewayUs50 $gateway
 * @property ?array<ServiceUs50> $services
 */
trait PricingAgreementUs50
{
    /**
     * @var value-of<PricingAgreementUs50Country> $country Two-digit code for the country that the pricing intent applies to. The format follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public string $country;

    /**
     * @var value-of<PricingAgreementUs50Version> $version Version of the MPA.
     */
    #[JsonProperty('version')]
    public string $version;

    /**
     * @var BaseUs $base
     */
    #[JsonProperty('base')]
    public BaseUs $base;

    /**
     * @var ?PricingAgreementUs50Processor $processor Object that contains information about U.S. processor fees.
     */
    #[JsonProperty('processor')]
    public ?PricingAgreementUs50Processor $processor;

    /**
     * @var ?GatewayUs50 $gateway
     */
    #[JsonProperty('gateway')]
    public ?GatewayUs50 $gateway;

    /**
     * @var ?array<ServiceUs50> $services
     */
    #[JsonProperty('services'), ArrayType([ServiceUs50::class])]
    public ?array $services;
}
