<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class Subscription extends JsonSerializableType
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
     * @var PaymentPlanSummary $paymentPlan
     */
    #[JsonProperty('paymentPlan')]
    public PaymentPlanSummary $paymentPlan;

    /**
     * @var SecureTokenSummary $secureToken
     */
    #[JsonProperty('secureToken')]
    public SecureTokenSummary $secureToken;

    /**
     * @var string $name Name of the subscription.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var ?string $description Description of the subscription.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * @var ?SubscriptionPaymentOrder $setupOrder
     */
    #[JsonProperty('setupOrder')]
    public ?SubscriptionPaymentOrder $setupOrder;

    /**
     * @var ?SubscriptionRecurringOrder $recurringOrder
     */
    #[JsonProperty('recurringOrder')]
    public ?SubscriptionRecurringOrder $recurringOrder;

    /**
     * @var SubscriptionState $currentState
     */
    #[JsonProperty('currentState')]
    public SubscriptionState $currentState;

    /**
     * Format: **YYYY-MM-DD**
     * Subscription's start date.
     *
     * @var DateTime $startDate
     */
    #[JsonProperty('startDate'), Date(Date::TYPE_DATE)]
    public DateTime $startDate;

    /**
     * Format: **YYYY-MM-DD**
     * Subscription's end date.
     * **Note:** If you provide values for both **length** and **endDate**,
     * our gateway uses the value for **endDate** to determine when the subscription should end.
     *
     * @var ?DateTime $endDate
     */
    #[JsonProperty('endDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $endDate;

    /**
     * Total number of billing cycles. To indicate that the subscription should run indefinitely, send a value of `0`. This value replaces the **length** inherited from the payment plan.
     * **Note:** If you provide values for both **length** and **endDate**, our gateway uses the value for **endDate** to determine when the subscription should end.
     *
     * @var ?int $length
     */
    #[JsonProperty('length')]
    public ?int $length;

    /**
     * How the merchant takes the payment from the customer’s account.
     * - `manual` – The merchant manually collects payments from the customer.
     * - `automatic` – The terminal automatically collects payments from the customer.
     *
     * @var value-of<SubscriptionType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var value-of<SubscriptionFrequency> $frequency Indicates how often the merchant or the terminal collects a payment from the customer.
     */
    #[JsonProperty('frequency')]
    public string $frequency;

    /**
     * Number of billing cycles that the merchant wants to pause payments for.
     * For example, if the merchant wants to offer a free trial period.
     *
     * @var ?int $pauseCollectionFor
     */
    #[JsonProperty('pauseCollectionFor')]
    public ?int $pauseCollectionFor;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   subscriptionId: string,
     *   processingTerminalId: string,
     *   paymentPlan: PaymentPlanSummary,
     *   secureToken: SecureTokenSummary,
     *   name: string,
     *   currency: value-of<Currency>,
     *   currentState: SubscriptionState,
     *   startDate: DateTime,
     *   type: value-of<SubscriptionType>,
     *   frequency: value-of<SubscriptionFrequency>,
     *   description?: ?string,
     *   setupOrder?: ?SubscriptionPaymentOrder,
     *   recurringOrder?: ?SubscriptionRecurringOrder,
     *   endDate?: ?DateTime,
     *   length?: ?int,
     *   pauseCollectionFor?: ?int,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->subscriptionId = $values['subscriptionId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->paymentPlan = $values['paymentPlan'];
        $this->secureToken = $values['secureToken'];
        $this->name = $values['name'];
        $this->description = $values['description'] ?? null;
        $this->currency = $values['currency'];
        $this->setupOrder = $values['setupOrder'] ?? null;
        $this->recurringOrder = $values['recurringOrder'] ?? null;
        $this->currentState = $values['currentState'];
        $this->startDate = $values['startDate'];
        $this->endDate = $values['endDate'] ?? null;
        $this->length = $values['length'] ?? null;
        $this->type = $values['type'];
        $this->frequency = $values['frequency'];
        $this->pauseCollectionFor = $values['pauseCollectionFor'] ?? null;
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
