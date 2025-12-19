<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about U.S. processor fees.
 */
class PricingAgreementUs50Processor extends JsonSerializableType
{
    /**
     * @var ?PricingAgreementUs50ProcessorCard $card Object that contains information about card fees.
     */
    #[JsonProperty('card')]
    public ?PricingAgreementUs50ProcessorCard $card;

    /**
     * @var ?Ach $ach
     */
    #[JsonProperty('ach')]
    public ?Ach $ach;

    /**
     * @param array{
     *   card?: ?PricingAgreementUs50ProcessorCard,
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
