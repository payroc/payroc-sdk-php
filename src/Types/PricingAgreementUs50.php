<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about U.S. pricing intents for Merchant Processing Agreement (MPA) 5.0.
 */
class PricingAgreementUs50 extends JsonSerializableType
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

    /**
     * @param array{
     *   country: value-of<PricingAgreementUs50Country>,
     *   version: value-of<PricingAgreementUs50Version>,
     *   base: BaseUs,
     *   processor?: ?PricingAgreementUs50Processor,
     *   gateway?: ?GatewayUs50,
     *   services?: ?array<ServiceUs50>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->country = $values['country'];
        $this->version = $values['version'];
        $this->base = $values['base'];
        $this->processor = $values['processor'] ?? null;
        $this->gateway = $values['gateway'] ?? null;
        $this->services = $values['services'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
