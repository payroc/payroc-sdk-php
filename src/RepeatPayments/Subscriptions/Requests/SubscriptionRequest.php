<?php

namespace Payroc\RepeatPayments\Subscriptions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\RepeatPayments\Subscriptions\Types\SubscriptionRequestPaymentMethod;
use Payroc\Types\SubscriptionPaymentOrderRequest;
use Payroc\Types\SubscriptionRecurringOrderRequest;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class SubscriptionRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var string $subscriptionId Unique identifier that the merchant assigned to the subscription.
     */
    #[JsonProperty('subscriptionId')]
    public string $subscriptionId;

    /**
     * @var string $paymentPlanId Unique identifier that the merchant assigned to the payment plan.
     */
    #[JsonProperty('paymentPlanId')]
    public string $paymentPlanId;

    /**
     * @var SubscriptionRequestPaymentMethod $paymentMethod Object that contains information about the customer's payment details.
     */
    #[JsonProperty('paymentMethod')]
    public SubscriptionRequestPaymentMethod $paymentMethod;

    /**
     * Name of the subscription.
     * This value replaces the name inherited from the payment plan.
     *
     * @var ?string $name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * Description of the subscription.
     * This value replaces the description inherited from the payment plan.
     *
     * @var ?string $description
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?SubscriptionPaymentOrderRequest $setupOrder
     */
    #[JsonProperty('setupOrder')]
    public ?SubscriptionPaymentOrderRequest $setupOrder;

    /**
     * @var ?SubscriptionRecurringOrderRequest $recurringOrder
     */
    #[JsonProperty('recurringOrder')]
    public ?SubscriptionRecurringOrderRequest $recurringOrder;

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
     * Total number of billing cycles. To indicate that the subscription should run indefinitely, send a value of `0`.
     * This value replaces the **length** inherited from the payment plan.
     * **Note:** If you provide values for both **length** and **endDate**,
     * our gateway uses the value for **endDate** to determine when the subscription should end.
     *
     * @var ?int $length
     */
    #[JsonProperty('length')]
    public ?int $length;

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
     *   idempotencyKey: string,
     *   subscriptionId: string,
     *   paymentPlanId: string,
     *   paymentMethod: SubscriptionRequestPaymentMethod,
     *   startDate: DateTime,
     *   name?: ?string,
     *   description?: ?string,
     *   setupOrder?: ?SubscriptionPaymentOrderRequest,
     *   recurringOrder?: ?SubscriptionRecurringOrderRequest,
     *   endDate?: ?DateTime,
     *   length?: ?int,
     *   pauseCollectionFor?: ?int,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->subscriptionId = $values['subscriptionId'];
        $this->paymentPlanId = $values['paymentPlanId'];
        $this->paymentMethod = $values['paymentMethod'];
        $this->name = $values['name'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->setupOrder = $values['setupOrder'] ?? null;
        $this->recurringOrder = $values['recurringOrder'] ?? null;
        $this->startDate = $values['startDate'];
        $this->endDate = $values['endDate'] ?? null;
        $this->length = $values['length'] ?? null;
        $this->pauseCollectionFor = $values['pauseCollectionFor'] ?? null;
        $this->customFields = $values['customFields'] ?? null;
    }
}
