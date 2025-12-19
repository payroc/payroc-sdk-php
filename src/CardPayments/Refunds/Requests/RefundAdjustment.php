<?php

namespace Payroc\CardPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\CardPayments\Refunds\Types\RefundAdjustmentAdjustmentsItem;
use Payroc\Core\Types\ArrayType;

class RefundAdjustment extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who requested the adjustment to the refund.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var array<RefundAdjustmentAdjustmentsItem> $adjustments Array of objects that contain information about the adjustments to the refund.
     */
    #[JsonProperty('adjustments'), ArrayType([RefundAdjustmentAdjustmentsItem::class])]
    public array $adjustments;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   adjustments: array<RefundAdjustmentAdjustmentsItem>,
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
