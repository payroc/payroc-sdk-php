<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about saving the customer’s payment details.
 */
class SchemasCredentialOnFile extends JsonSerializableType
{
    /**
     * @var ?bool $externalVault Indicates if the merchant uses a third-party vault to store the customer’s payment details.
     */
    #[JsonProperty('externalVault')]
    public ?bool $externalVault;

    /**
     * @var ?bool $tokenize Indicates if our gateway should tokenize the customer’s payment details as part of the transaction.
     */
    #[JsonProperty('tokenize')]
    public ?bool $tokenize;

    /**
     * Unique identifier that the merchant creates for the secure token that represents the customer’s payment details.
     * **Note:** If you do not send a value for the **secureTokenId**, our gateway generates a unique identifier for the token.
     *
     * @var ?string $secureTokenId
     */
    #[JsonProperty('secureTokenId')]
    public ?string $secureTokenId;

    /**
     * Indicates how the merchant can use the customer’s card details, as agreed by the customer:
     *
     * - `unscheduled` - Transactions for a fixed or variable amount that are run at a certain pre-defined event.
     * - `recurring` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Recurring transactions don’t have a fixed duration and run until the customer cancels the agreement.
     * - `installment` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Installment transactions have a fixed duration.
     *
     * **Note:** If you send a value for **mitAgreement**, you must send the **standingInstructions** object in the **paymentOrder** object.
     *
     * @var ?value-of<SchemasCredentialOnFileMitAgreement> $mitAgreement
     */
    #[JsonProperty('mitAgreement')]
    public ?string $mitAgreement;

    /**
     * @param array{
     *   externalVault?: ?bool,
     *   tokenize?: ?bool,
     *   secureTokenId?: ?string,
     *   mitAgreement?: ?value-of<SchemasCredentialOnFileMitAgreement>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->externalVault = $values['externalVault'] ?? null;
        $this->tokenize = $values['tokenize'] ?? null;
        $this->secureTokenId = $values['secureTokenId'] ?? null;
        $this->mitAgreement = $values['mitAgreement'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
