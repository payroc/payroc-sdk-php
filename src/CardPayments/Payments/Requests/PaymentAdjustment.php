<?php

namespace Payroc\CardPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\CardPayments\Payments\Types\PaymentAdjustmentAdjustmentsItem;
use Payroc\Core\Types\ArrayType;

class PaymentAdjustment extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who adjusted the payment.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * Array of polymorphic objects which contain information about adjustments to a payment.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`order` - Tip information.
     * -	`status` - Status of the transaction.
     * -	`customer` - Customer's contact information and shipping address.
     * -	`signature` - Customer's signature.
     *
     * @var array<PaymentAdjustmentAdjustmentsItem> $adjustments
     */
    #[JsonProperty('adjustments'), ArrayType([PaymentAdjustmentAdjustmentsItem::class])]
    public array $adjustments;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   adjustments: array<PaymentAdjustmentAdjustmentsItem>,
     *   operator?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->operator = $values['operator'] ?? null;
        $this->adjustments = $values['adjustments'];
    }
}
