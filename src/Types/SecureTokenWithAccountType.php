<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class SecureTokenWithAccountType extends JsonSerializableType
{
    /**
     * @var ?SecureTokenWithAccountTypeSource $source Object that contains information about the payment method that we tokenized.
     */
    #[JsonProperty('source')]
    public ?SecureTokenWithAccountTypeSource $source;

    /**
     * @var string $secureTokenId Unique identifier that the merchant created for the secure token that represents the customer's payment details.
     */
    #[JsonProperty('secureTokenId')]
    public string $secureTokenId;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * Indicates how the merchant can use the customer's card details, as agreed by the customer:
     *
     * - `unscheduled` - Transactions for a fixed or variable amount that are run at a certain pre-defined event.
     * - `recurring` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Recurring transactions don't have a fixed duration and run until the customer cancels the agreement.
     * - `installment` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Installment transactions have a fixed duration.
     *
     * @var ?value-of<SecureTokenMitAgreement> $mitAgreement
     */
    #[JsonProperty('mitAgreement')]
    public ?string $mitAgreement;

    /**
     * @var ?RetrievedCustomer $customer
     */
    #[JsonProperty('customer')]
    public ?RetrievedCustomer $customer;

    /**
     * Token that the merchant can use in future transactions to represent the customer's payment details. The token:
     * - Begins with the six-digit identification number **296753**.
     * - Contains up to 12 digits.
     * - Contains a single check digit that we calculate using the Luhn algorithm.
     *
     * @var string $token
     */
    #[JsonProperty('token')]
    public string $token;

    /**
     * Outcome of a security check on the status of the customer's payment card or bank account.
     *
     * **Note:** Depending on the merchant's account settings, this feature may be unavailable.
     *
     * @var value-of<SecureTokenStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   secureTokenId: string,
     *   processingTerminalId: string,
     *   token: string,
     *   status: value-of<SecureTokenStatus>,
     *   source?: ?SecureTokenWithAccountTypeSource,
     *   mitAgreement?: ?value-of<SecureTokenMitAgreement>,
     *   customer?: ?RetrievedCustomer,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->source = $values['source'] ?? null;
        $this->secureTokenId = $values['secureTokenId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->mitAgreement = $values['mitAgreement'] ?? null;
        $this->customer = $values['customer'] ?? null;
        $this->token = $values['token'];
        $this->status = $values['status'];
        $this->customFields = $values['customFields'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
