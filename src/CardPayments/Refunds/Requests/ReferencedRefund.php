<?php

namespace Payroc\CardPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class ReferencedRefund extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who refunded the payment.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var int $amount Amount of the payment that the merchant wants to refund. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var string $description Reason for the refund.
     */
    #[JsonProperty('description')]
    public string $description;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   amount: int,
     *   description: string,
     *   operator?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->operator = $values['operator'] ?? null;
        $this->amount = $values['amount'];
        $this->description = $values['description'];
    }
}
