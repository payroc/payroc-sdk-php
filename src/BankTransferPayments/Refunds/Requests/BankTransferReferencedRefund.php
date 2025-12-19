<?php

namespace Payroc\BankTransferPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class BankTransferReferencedRefund extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var int $amount Total amount of the refund. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var string $description Description of the refund.
     */
    #[JsonProperty('description')]
    public string $description;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   amount: int,
     *   description: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->amount = $values['amount'];
        $this->description = $values['description'];
    }
}
