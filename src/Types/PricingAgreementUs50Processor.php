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
     * Polymorphic object that contains fees for card transactions.
     *
     * The value of the planType field determines which variant you should use:
     * -	`interchangePlus` - Interchange + pricing
     * -	`interchangePlusPlus` - Interchange pricing with three tiers
     * -	`tiered3` - Three-tiered pricing
     * -	`tiered4` - Four-tiered pricing
     * -	`tiered6` - Six-tiered pricing
     * -	`flatRate` - Flat rate pricing
     * -	`consumerChoice` - ConsumerChoice
     * -	`rewardPayChoice` - RewardPayChoice
     *
     * @var ?PricingAgreementUs50ProcessorCard $card
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
