<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that indicates if the merchant accepts Electronic Benefits Transfer (EBT) cards and contains the merchant’s Food and Nutrition Services (FNS) number.
 */
class ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer extends JsonSerializableType
{
    /**
     * @var ?bool $enabled Indicates if the merchant accepts EBT.
     */
    #[JsonProperty('enabled')]
    public ?bool $enabled;

    /**
     * @var ?string $fnsNumber If the merchant accepts EBT, provide their FNS number.
     */
    #[JsonProperty('fnsNumber')]
    public ?string $fnsNumber;

    /**
     * @param array{
     *   enabled?: ?bool,
     *   fnsNumber?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->enabled = $values['enabled'] ?? null;
        $this->fnsNumber = $values['fnsNumber'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
