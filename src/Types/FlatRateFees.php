<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the Flat Rate fees.
 */
class FlatRateFees extends JsonSerializableType
{
    /**
     * @var ProcessorFee $standardCards Object that contains the fees for standard card transactions.
     */
    #[JsonProperty('standardCards')]
    public ProcessorFee $standardCards;

    /**
     * @var ?FlatRateFeesAmex $amex Object that contains the fees for American Express transactions.
     */
    #[JsonProperty('amex')]
    public ?FlatRateFeesAmex $amex;

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
     *   standardCards: ProcessorFee,
     *   amex?: ?FlatRateFeesAmex,
     *   pinDebit?: ?PinDebit,
     *   electronicBenefitsTransfer?: ?ElectronicBenefitsTransfer,
     *   specialityCards?: ?SpecialityCards,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->standardCards = $values['standardCards'];
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
