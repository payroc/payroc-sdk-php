<?php

namespace Payroc\CardPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class PaymentReversal extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who reversed the payment.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * Amount of the payment that the merchant wants to reverse. The value is in the currency’s lowest denomination, for example, cents.
     * **Note:** If the merchant doesn’t send an amount, we reverse the total amount of the transaction.
     *
     * @var ?int $amount
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   operator?: ?string,
     *   amount?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->operator = $values['operator'] ?? null;
        $this->amount = $values['amount'] ?? null;
    }
}
