<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the transaction response details.
 */
class TransactionResult extends JsonSerializableType
{
    /**
     * @var ?value-of<TransactionResultType> $type Transaction type.
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?value-of<TransactionResultEbtType> $ebtType Indicates the subtype of EBT in the transaction.
     */
    #[JsonProperty('ebtType')]
    public ?string $ebtType;

    /**
     * @var value-of<TransactionResultStatus> $status Current status of the transaction.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?string $approvalCode Authorization code that the processor assigned to the transaction.
     */
    #[JsonProperty('approvalCode')]
    public ?string $approvalCode;

    /**
     * Amount that the processor authorized for the transaction. This value is in the currency’s lowest denomination, for example, cents.
     *
     * **Notes:**
     * - For partial authorizations, this amount is lower than the amount in the request.
     * - If the value for **authorizedAmount** is negative, this indicates that the merchant sent funds to the customer.
     *
     * @var ?int $authorizedAmount
     */
    #[JsonProperty('authorizedAmount')]
    public ?int $authorizedAmount;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * Response from the processor.
     * - `A` - The processor approved the transaction.
     * - `D` - The processor declined the transaction.
     * - `E` - The processor received the transaction but will process the transaction later.
     * - `P` - The processor authorized a portion of the original amount of the transaction.
     * - `R` - The issuer declined the transaction and indicated that the customer should contact their bank.
     * - `C` - The issuer declined the transaction and indicated that the merchant should keep the card as it was reported lost or stolen.
     *
     * @var value-of<TransactionResultResponseCode> $responseCode
     */
    #[JsonProperty('responseCode')]
    public string $responseCode;

    /**
     * @var ?string $responseMessage Response description from the processor.
     */
    #[JsonProperty('responseMessage')]
    public ?string $responseMessage;

    /**
     * @var ?string $processorResponseCode Original response code that the processor sent.
     */
    #[JsonProperty('processorResponseCode')]
    public ?string $processorResponseCode;

    /**
     * @var ?string $cardSchemeReferenceId Identifier that the card brand assigns to the payment instruction.
     */
    #[JsonProperty('cardSchemeReferenceId')]
    public ?string $cardSchemeReferenceId;

    /**
     * @param array{
     *   status: value-of<TransactionResultStatus>,
     *   responseCode: value-of<TransactionResultResponseCode>,
     *   type?: ?value-of<TransactionResultType>,
     *   ebtType?: ?value-of<TransactionResultEbtType>,
     *   approvalCode?: ?string,
     *   authorizedAmount?: ?int,
     *   currency?: ?value-of<Currency>,
     *   responseMessage?: ?string,
     *   processorResponseCode?: ?string,
     *   cardSchemeReferenceId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'] ?? null;
        $this->ebtType = $values['ebtType'] ?? null;
        $this->status = $values['status'];
        $this->approvalCode = $values['approvalCode'] ?? null;
        $this->authorizedAmount = $values['authorizedAmount'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->responseCode = $values['responseCode'];
        $this->responseMessage = $values['responseMessage'] ?? null;
        $this->processorResponseCode = $values['processorResponseCode'] ?? null;
        $this->cardSchemeReferenceId = $values['cardSchemeReferenceId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
