<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the transaction.
 */
class BankTransferResult extends JsonSerializableType
{
    /**
     * @var value-of<BankTransferResultType> $type Type of transaction.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var value-of<BankTransferResultStatus> $status Status of the transaction.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * Amount of the transaction.
     * **Note:** The amount is negative for a refund.
     *
     * @var ?float $authorizedAmount
     */
    #[JsonProperty('authorizedAmount')]
    public ?float $authorizedAmount;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * Response from the processor.
     * - `A` - The processor approved the transaction.
     * - `D` - The processor declined the transaction.
     *
     * @var ?string $responseCode
     */
    #[JsonProperty('responseCode')]
    public ?string $responseCode;

    /**
     * @var string $responseMessage Description of the response from the processor.
     */
    #[JsonProperty('responseMessage')]
    public string $responseMessage;

    /**
     * @var ?string $processorResponseCode Original response code that the processor sent.
     */
    #[JsonProperty('processorResponseCode')]
    public ?string $processorResponseCode;

    /**
     * @param array{
     *   type: value-of<BankTransferResultType>,
     *   status: value-of<BankTransferResultStatus>,
     *   responseMessage: string,
     *   authorizedAmount?: ?float,
     *   currency?: ?value-of<Currency>,
     *   responseCode?: ?string,
     *   processorResponseCode?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->status = $values['status'];
        $this->authorizedAmount = $values['authorizedAmount'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->responseCode = $values['responseCode'] ?? null;
        $this->responseMessage = $values['responseMessage'];
        $this->processorResponseCode = $values['processorResponseCode'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
