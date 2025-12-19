<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the fees.
 */
class Tiered3Fees extends JsonSerializableType
{
    /**
     * @var QualRates $mastercardVisaDiscover Object that contains the fees for Mastercard, Visa, and Discover transactions.
     */
    #[JsonProperty('mastercardVisaDiscover')]
    public QualRates $mastercardVisaDiscover;

    /**
     * @var ?Tiered3FeesAmex $amex Object that contains the fees for American Express transactions.
     */
    #[JsonProperty('amex')]
    public ?Tiered3FeesAmex $amex;

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
     *   mastercardVisaDiscover: QualRates,
     *   amex?: ?Tiered3FeesAmex,
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
