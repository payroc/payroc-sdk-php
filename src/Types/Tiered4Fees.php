<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the fees.
 */
class Tiered4Fees extends JsonSerializableType
{
    /**
     * @var QualRatesWithPremium $mastercardVisaDiscover Object that contains the fees for Mastercard, Visa, and Discover transactions.
     */
    #[JsonProperty('mastercardVisaDiscover')]
    public QualRatesWithPremium $mastercardVisaDiscover;

    /**
     * Polymorphic object that contains fees for American Express transactions.
     *
     * The value of the type field determines which variant you should use:
     * -	`optBlue` - Amex OptBlue pricing program.
     * -	`direct` - Amex Direct pricing program.
     *
     * @var ?Tiered4FeesAmex $amex
     */
    #[JsonProperty('amex')]
    public ?Tiered4FeesAmex $amex;

    /**
     * @var ?PinDebit $pinDebit
     */
    #[JsonProperty('pinDebit')]
    public ?PinDebit $pinDebit;

    /**
     * @var ?ElectronicBenefitsTransfer $electronicBenefitsTransfer
     */
    #[JsonProperty('electronicBenefitsTransfer')]
    public ?ElectronicBenefitsTransfer $electronicBenefitsTransfer;

    /**
     * @var ?SpecialityCards $specialityCards
     */
    #[JsonProperty('specialityCards')]
    public ?SpecialityCards $specialityCards;

    /**
     * @param array{
     *   mastercardVisaDiscover: QualRatesWithPremium,
     *   amex?: ?Tiered4FeesAmex,
     *   pinDebit?: ?PinDebit,
     *   electronicBenefitsTransfer?: ?ElectronicBenefitsTransfer,
     *   specialityCards?: ?SpecialityCards,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->mastercardVisaDiscover = $values['mastercardVisaDiscover'];
        $this->amex = $values['amex'] ?? null;
        $this->pinDebit = $values['pinDebit'] ?? null;
        $this->electronicBenefitsTransfer = $values['electronicBenefitsTransfer'] ?? null;
        $this->specialityCards = $values['specialityCards'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
