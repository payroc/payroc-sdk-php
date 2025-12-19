<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the payment details for the customer’s preauthorized electronic debit (PAD) transactions.
 */
class PadPayload extends JsonSerializableType
{
    /**
     * Indicates the customer’s account type.
     * **Note:** For bank account details, send a value for accountType.
     *
     * @var ?value-of<PadPayloadAccountType> $accountType
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * @var string $nameOnAccount Customer's name.
     */
    #[JsonProperty('nameOnAccount')]
    public string $nameOnAccount;

    /**
     * Customer's account number.
     * **Note:** In responses, our gateway shows only the last four digits of the account number, for example, `*****5929`.
     *
     * @var string $accountNumber
     */
    #[JsonProperty('accountNumber')]
    public string $accountNumber;

    /**
     * @var string $transitNumber Five-digit number that identifies the customer's bank branch.
     */
    #[JsonProperty('transitNumber')]
    public string $transitNumber;

    /**
     * @var string $institutionNumber Three-digit number that identifies the customer's bank.
     */
    #[JsonProperty('institutionNumber')]
    public string $institutionNumber;

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   transitNumber: string,
     *   institutionNumber: string,
     *   accountType?: ?value-of<PadPayloadAccountType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountType = $values['accountType'] ?? null;
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->accountNumber = $values['accountNumber'];
        $this->transitNumber = $values['transitNumber'];
        $this->institutionNumber = $values['institutionNumber'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
