<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class SubscriptionPayment extends JsonSerializableType
{
    /**
     * @var string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     */
    #[JsonProperty('subscriptionId')]
    public string $subscriptionId;

    /**
     * @var string $processingTerminalId Unique identifier of the terminal that the subscription is linked to.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var PaymentSummary $payment
     */
    #[JsonProperty('payment')]
    public PaymentSummary $payment;

    /**
     * @var SecureTokenSummary $secureToken
     */
    #[JsonProperty('secureToken')]
    public SecureTokenSummary $secureToken;

    /**
     * @var SubscriptionState $currentState
     */
    #[JsonProperty('currentState')]
    public SubscriptionState $currentState;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   subscriptionId: string,
     *   processingTerminalId: string,
     *   payment: PaymentSummary,
     *   secureToken: SecureTokenSummary,
     *   currentState: SubscriptionState,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subscriptionId = $values['subscriptionId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->payment = $values['payment'];
        $this->secureToken = $values['secureToken'];
        $this->currentState = $values['currentState'];
        $this->customFields = $values['customFields'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
