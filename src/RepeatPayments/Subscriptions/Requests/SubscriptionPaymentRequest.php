<?php

namespace Payroc\RepeatPayments\Subscriptions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\SubscriptionPaymentOrder;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class SubscriptionPaymentRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var SubscriptionPaymentOrder $order Object that contains information about the payment.
     */
    #[JsonProperty('order')]
    public SubscriptionPaymentOrder $order;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   order: SubscriptionPaymentOrder,
     *   operator?: ?string,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->operator = $values['operator'] ?? null;
        $this->order = $values['order'];
        $this->customFields = $values['customFields'] ?? null;
    }
}
