<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that indicates if the merchant accepts American Express Direct cards and contains the merchant’s American Express merchant number.
 */
class ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect extends JsonSerializableType
{
    /**
     * @var ?bool $enabled Indicates if the merchant accepts American Express Direct.
     */
    #[JsonProperty('enabled')]
    public ?bool $enabled;

    /**
     * @var ?string $merchantNumber If the merchant accepts American Express Direct, provide their American Express merchant number.
     */
    #[JsonProperty('merchantNumber')]
    public ?string $merchantNumber;

    /**
     * @param array{
     *   enabled?: ?bool,
     *   merchantNumber?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->enabled = $values['enabled'] ?? null;
        $this->merchantNumber = $values['merchantNumber'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
