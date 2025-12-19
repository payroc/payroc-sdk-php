<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class PaymentPlanSummary extends JsonSerializableType
{
    /**
     * @var string $paymentPlanId Unique identifier that the merchant assigns to the payment plan.
     */
    #[JsonProperty('paymentPlanId')]
    public string $paymentPlanId;

    /**
     * @var string $name Name of the payment plan.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   paymentPlanId: string,
     *   name: string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentPlanId = $values['paymentPlanId'];
        $this->name = $values['name'];
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
