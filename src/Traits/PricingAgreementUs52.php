<?php

namespace Payroc\Traits;

use Payroc\Types\PricingAgreementUs52Country;
use Payroc\Types\PricingAgreementUs52Version;
use Payroc\Types\BaseUs;
use Payroc\Types\PricingAgreementUs52Processor;
use Payroc\Types\GatewayUs52;
use Payroc\Types\ServiceUs50;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about U.S. pricing intents for Merchant Processing Agreement (MPA) 5.2.
 *
 * @property value-of<PricingAgreementUs52Country> $country
 * @property value-of<PricingAgreementUs52Version> $version
 * @property BaseUs $base
 * @property ?PricingAgreementUs52Processor $processor
 * @property ?GatewayUs52 $gateway
 * @property ?array<ServiceUs50> $services
 */
trait PricingAgreementUs52
{
    /**
     * @var value-of<PricingAgreementUs52Country> $country Two-digit code for the country that the pricing intent applies to. The format follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public string $country;

    /**
     * @var value-of<PricingAgreementUs52Version> $version Version of the MPA.
     */
    #[JsonProperty('version')]
    public string $version;

    /**
     * @var BaseUs $base
     */
    #[JsonProperty('base')]
    public BaseUs $base;

    /**
     * @var ?PricingAgreementUs52Processor $processor Object that contains information about U.S. processor fees.
     */
    #[JsonProperty('processor')]
    public ?PricingAgreementUs52Processor $processor;

    /**
     * @var ?GatewayUs52 $gateway
     */
    #[JsonProperty('gateway')]
    public ?GatewayUs52 $gateway;

    /**
     * @var ?array<ServiceUs50> $services
     */
    #[JsonProperty('services'), ArrayType([ServiceUs50::class])]
    public ?array $services;
}
