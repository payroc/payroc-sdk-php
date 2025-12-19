<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about U.S. pricing intents for Merchant Processing Agreement (MPA) 4.0.
 */
class PricingAgreementUs40 extends JsonSerializableType
{
    /**
     * @var value-of<PricingAgreementUs40Country> $country Two-digit code for the country that the pricing intent applies to. The format follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public string $country;

    /**
     * @var value-of<PricingAgreementUs40Version> $version Version of the MPA.
     */
    #[JsonProperty('version')]
    public string $version;

    /**
     * @var BaseUs $base
     */
    #[JsonProperty('base')]
    public BaseUs $base;

    /**
     * @var ?PricingAgreementUs40Processor $processor Object that contains information about U.S. processor fees.
     */
    #[JsonProperty('processor')]
    public ?PricingAgreementUs40Processor $processor;

    /**
     * @var ?GatewayUs $gateway
     */
    #[JsonProperty('gateway')]
    public ?GatewayUs $gateway;

    /**
     * @param array{
     *   country: value-of<PricingAgreementUs40Country>,
     *   version: value-of<PricingAgreementUs40Version>,
     *   base: BaseUs,
     *   processor?: ?PricingAgreementUs40Processor,
     *   gateway?: ?GatewayUs,
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
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
