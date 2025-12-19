<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about dual pricing.
 */
class DualPricing extends JsonSerializableType
{
    /**
     * @var bool $offered Indicates if the merchant offered dual pricing to the customer.
     */
    #[JsonProperty('offered')]
    public bool $offered;

    /**
     * Object that contains information about the choice rate.
     * **Note:** For requests, if the value for **offered** is `true`, you must send this object in the request.
     *
     * @var ?ChoiceRate $choiceRate
     */
    #[JsonProperty('choiceRate')]
    public ?ChoiceRate $choiceRate;

    /**
     * Payment method that the merchant presented to the customer as an alternative to their chosen method.
     * **Note:** For requests, if the value for **offered** is `true`, you must send a value for **alternativeTender** in the request.
     *
     * @var ?value-of<DualPricingAlternativeTender> $alternativeTender
     */
    #[JsonProperty('alternativeTender')]
    public ?string $alternativeTender;

    /**
     * @param array{
     *   offered: bool,
     *   choiceRate?: ?ChoiceRate,
     *   alternativeTender?: ?value-of<DualPricingAlternativeTender>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->offered = $values['offered'];
        $this->choiceRate = $values['choiceRate'] ?? null;
        $this->alternativeTender = $values['alternativeTender'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
