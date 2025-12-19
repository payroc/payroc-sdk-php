<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about saving the customer’s payment details.
 */
class CredentialOnFile extends JsonSerializableType
{
    /**
     * @var ?bool $tokenize Indicates if our gateway should tokenize the customer’s payment details as part of the transaction.
     */
    #[JsonProperty('tokenize')]
    public ?bool $tokenize;

    /**
     * Indicates how the merchant can use the customer’s card details, as agreed by the customer:
     *
     * - `unscheduled` - Transactions for a fixed or variable amount that are run at a certain pre-defined event.
     * - `recurring` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Recurring transactions don’t have a fixed duration and run until the customer cancels the agreement.
     * - `installment` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Installment transactions have a fixed duration.
     *
     * **Note:** If you send a value for **mitAgreement**, you must send the **standingInstructions** object in the **paymentOrder** object.
     *
     * @var ?value-of<CredentialOnFileMitAgreement> $mitAgreement
     */
    #[JsonProperty('mitAgreement')]
    public ?string $mitAgreement;

    /**
     * @param array{
     *   tokenize?: ?bool,
     *   mitAgreement?: ?value-of<CredentialOnFileMitAgreement>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->tokenize = $values['tokenize'] ?? null;
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
