<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Information about the speciality cards that the merchant accepts.
 */
class ProcessingCardAcceptanceSpecialityCards extends JsonSerializableType
{
    /**
     * @var ?ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect $americanExpressDirect Object that indicates if the merchant accepts American Express Direct cards and contains the merchant’s American Express merchant number.
     */
    #[JsonProperty('americanExpressDirect')]
    public ?ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect $americanExpressDirect;

    /**
     * @var ?ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer $electronicBenefitsTransfer Object that indicates if the merchant accepts Electronic Benefits Transfer (EBT) cards and contains the merchant’s Food and Nutrition Services (FNS) number.
     */
    #[JsonProperty('electronicBenefitsTransfer')]
    public ?ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer $electronicBenefitsTransfer;

    /**
     * @var ?ProcessingCardAcceptanceSpecialityCardsOther $other Object that contains information about other speciality cards that the merchant accepts.
     */
    #[JsonProperty('other')]
    public ?ProcessingCardAcceptanceSpecialityCardsOther $other;

    /**
     * @param array{
     *   americanExpressDirect?: ?ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect,
     *   electronicBenefitsTransfer?: ?ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer,
     *   other?: ?ProcessingCardAcceptanceSpecialityCardsOther,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->americanExpressDirect = $values['americanExpressDirect'] ?? null;
        $this->electronicBenefitsTransfer = $values['electronicBenefitsTransfer'] ?? null;
        $this->other = $values['other'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
