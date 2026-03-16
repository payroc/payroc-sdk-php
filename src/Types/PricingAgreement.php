<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class PricingAgreement extends JsonSerializableType
{
    /**
     * @var ?value-of<PricingAgreementCountry> $country Two-digit code for the country that the pricing intent applies to. The format follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @var ?value-of<PricingAgreementVersion> $version Version of the MPA.
     */
    #[JsonProperty('version')]
    public ?string $version;

    /**
     * @var ?BaseUs $base
     */
    #[JsonProperty('base')]
    public ?BaseUs $base;

    /**
     * @var ?PricingAgreementProcessor $processor Object that contains information about U.S. processor fees.
     */
    #[JsonProperty('processor')]
    public ?PricingAgreementProcessor $processor;

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

    /**
     * @param array{
     *   country?: ?value-of<PricingAgreementCountry>,
     *   version?: ?value-of<PricingAgreementVersion>,
     *   base?: ?BaseUs,
     *   processor?: ?PricingAgreementProcessor,
     *   gateway?: ?GatewayUs52,
     *   services?: ?array<ServiceUs50>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->country = $values['country'] ?? null;
        $this->version = $values['version'] ?? null;
        $this->base = $values['base'] ?? null;
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
