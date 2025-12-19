<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class CardVerificationResult extends JsonSerializableType
{
    /**
     * @var ?string $operator Operator who requested to verify the card.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?Card $card
     */
    #[JsonProperty('card')]
    public ?Card $card;

    /**
     * Indicates if the card details are valid:
     *
     * - `true` - Card details are valid.
     * - `false` - Card details are not valid.
     *
     * @var bool $verified
     */
    #[JsonProperty('verified')]
    public bool $verified;

    /**
     * @var ?TransactionResult $transactionResult
     */
    #[JsonProperty('transactionResult')]
    public ?TransactionResult $transactionResult;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   verified: bool,
     *   operator?: ?string,
     *   card?: ?Card,
     *   transactionResult?: ?TransactionResult,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->operator = $values['operator'] ?? null;
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->card = $values['card'] ?? null;
        $this->verified = $values['verified'];
        $this->transactionResult = $values['transactionResult'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
