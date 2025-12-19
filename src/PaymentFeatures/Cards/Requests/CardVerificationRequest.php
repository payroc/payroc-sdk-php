<?php

namespace Payroc\PaymentFeatures\Cards\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\Customer;
use Payroc\PaymentFeatures\Cards\Types\CardVerificationRequestCard;

class CardVerificationRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who requested to verify the card.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var ?Customer $customer
     */
    #[JsonProperty('customer')]
    public ?Customer $customer;

    /**
     * @var CardVerificationRequestCard $card Object that contains information about the card.
     */
    #[JsonProperty('card')]
    public CardVerificationRequestCard $card;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId: string,
     *   card: CardVerificationRequestCard,
     *   operator?: ?string,
     *   customer?: ?Customer,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->customer = $values['customer'] ?? null;
        $this->card = $values['card'];
    }
}
