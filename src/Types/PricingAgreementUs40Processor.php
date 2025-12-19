<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about U.S. processor fees.
 */
class PricingAgreementUs40Processor extends JsonSerializableType
{
    /**
     * @var ?PricingAgreementUs40ProcessorCard $card Object that contains the fees for card transactions.
     */
    #[JsonProperty('card')]
    public ?PricingAgreementUs40ProcessorCard $card;

    /**
     * @var ?Ach $ach
     */
    #[JsonProperty('ach')]
    public ?Ach $ach;

    /**
     * @param array{
     *   card?: ?PricingAgreementUs40ProcessorCard,
     *   ach?: ?Ach,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->card = $values['card'] ?? null;
        $this->ach = $values['ach'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
