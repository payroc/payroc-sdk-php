<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the fees.
 */
class ConsumerChoiceFees extends JsonSerializableType
{
    /**
     * @var int $monthlySubscription Fee for the monthly subscription for the processing plan. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthlySubscription')]
    public int $monthlySubscription;

    /**
     * @var float $volume Merchant-authorized percentage on non-cash transactions.
     */
    #[JsonProperty('volume')]
    public float $volume;

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
     *   monthlySubscription: int,
     *   volume: float,
     *   pinDebit?: ?PinDebit,
     *   electronicBenefitsTransfer?: ?ElectronicBenefitsTransfer,
     *   specialityCards?: ?SpecialityCards,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->monthlySubscription = $values['monthlySubscription'];
        $this->volume = $values['volume'];
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
