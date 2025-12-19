<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the fees.
 */
class InterchangePlusTiered3Fees extends JsonSerializableType
{
    /**
     * @var QualRates $mastercardVisaDiscover Object that contains the fees for Mastercard, Visa, and Discover transactions.
     */
    #[JsonProperty('mastercardVisaDiscover')]
    public QualRates $mastercardVisaDiscover;

    /**
     * @var ?InterchangePlusTiered3FeesAmex $amex Object that contains the fees for American Express transactions.
     */
    #[JsonProperty('amex')]
    public ?InterchangePlusTiered3FeesAmex $amex;

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
     * @var ?EnhancedInterchange $enhancedInterchange
     */
    #[JsonProperty('enhancedInterchange')]
    public ?EnhancedInterchange $enhancedInterchange;

    /**
     * @var ?SpecialityCards $specialityCards
     */
    #[JsonProperty('specialityCards')]
    public ?SpecialityCards $specialityCards;

    /**
     * @param array{
     *   mastercardVisaDiscover: QualRates,
     *   amex?: ?InterchangePlusTiered3FeesAmex,
     *   pinDebit?: ?PinDebit,
     *   electronicBenefitsTransfer?: ?ElectronicBenefitsTransfer,
     *   enhancedInterchange?: ?EnhancedInterchange,
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
        $this->enhancedInterchange = $values['enhancedInterchange'] ?? null;
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
