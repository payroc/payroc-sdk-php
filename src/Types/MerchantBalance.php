<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the total funds available to the merchant.
 */
class MerchantBalance extends JsonSerializableType
{
    /**
     * @var ?string $merchantId Unique identifier that the processor assigned to the merchant.
     */
    #[JsonProperty('merchantId')]
    public ?string $merchantId;

    /**
     * @var ?int $funds Total funding balance for the merchant, including pending amounts. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('funds')]
    public ?int $funds;

    /**
     * @var ?float $pending Amount of the funding balance that we have not yet sent to funding accounts. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('pending')]
    public ?float $pending;

    /**
     * @var ?float $available Amount of the funding balance that you can use in funding instructions. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('available')]
    public ?float $available;

    /**
     * @var ?string $currency Currency of the funding balance. We return a value of `USD`.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @param array{
     *   merchantId?: ?string,
     *   funds?: ?int,
     *   pending?: ?float,
     *   available?: ?float,
     *   currency?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->merchantId = $values['merchantId'] ?? null;
        $this->funds = $values['funds'] ?? null;
        $this->pending = $values['pending'] ?? null;
        $this->available = $values['available'] ?? null;
        $this->currency = $values['currency'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
