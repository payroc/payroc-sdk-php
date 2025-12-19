<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class Balance extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who requested the balance inquiry.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var Card $card
     */
    #[JsonProperty('card')]
    public Card $card;

    /**
     * Response from the processor.
     * - `A` - The processor approved the transaction.
     * - `D` - The processor declined the transaction.
     * - `E` - The processor received the transaction but will process the transaction later.
     * - `P` - The processor authorized a portion of the original amount of the transaction.
     * - `R` - The issuer declined the transaction and indicated that the customer should contact their bank.
     * - `C` - The issuer declined the transaction and indicated that the merchant should keep the card as it was reported lost or stolen.
     *
     * @var ?value-of<BalanceResponseCode> $responseCode
     */
    #[JsonProperty('responseCode')]
    public ?string $responseCode;

    /**
     * @var ?string $responseMessage Response description from the payment processor, for example, Refer to Card Issuer.
     */
    #[JsonProperty('responseMessage')]
    public ?string $responseMessage;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   card: Card,
     *   operator?: ?string,
     *   responseCode?: ?value-of<BalanceResponseCode>,
     *   responseMessage?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->card = $values['card'];
        $this->responseCode = $values['responseCode'] ?? null;
        $this->responseMessage = $values['responseMessage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
