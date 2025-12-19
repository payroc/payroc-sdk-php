<?php

namespace Payroc\CardPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\ItemizedBreakdownRequest;

class PaymentCapture extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $processingTerminalId Unique identifier that our gateway assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public ?string $processingTerminalId;

    /**
     * @var ?string $operator Operator who captured the payment.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * Amount that the merchant wants to capture. The value is in the currency's lowest denomination, for example, cents.
     * **Note:** If the merchant does not send an amount, we capture the total amount of the transaction.
     *
     * @var ?int $amount
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?ItemizedBreakdownRequest $breakdown
     */
    #[JsonProperty('breakdown')]
    public ?ItemizedBreakdownRequest $breakdown;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId?: ?string,
     *   operator?: ?string,
     *   amount?: ?int,
     *   breakdown?: ?ItemizedBreakdownRequest,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->processingTerminalId = $values['processingTerminalId'] ?? null;
        $this->operator = $values['operator'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->breakdown = $values['breakdown'] ?? null;
    }
}
