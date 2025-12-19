<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains shareable assets for the payment link.
 */
class PaymentLinkAssets extends JsonSerializableType
{
    /**
     * @var string $paymentUrl URL of the payment link.
     */
    #[JsonProperty('paymentUrl')]
    public string $paymentUrl;

    /**
     * @var string $paymentButton HTML code for the payment link. You can embed the HTML code in the merchant's website.
     */
    #[JsonProperty('paymentButton')]
    public string $paymentButton;

    /**
     * @param array{
     *   paymentUrl: string,
     *   paymentButton: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentUrl = $values['paymentUrl'];
        $this->paymentButton = $values['paymentButton'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
