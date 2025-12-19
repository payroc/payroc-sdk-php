<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's account details.
 */
class PadBankAccount extends JsonSerializableType
{
    /**
     * @var string $nameOnAccount Customer's name.
     */
    #[JsonProperty('nameOnAccount')]
    public string $nameOnAccount;

    /**
     * @var string $accountNumber Customer's bank account number. We mask all digits except the last four digits.
     */
    #[JsonProperty('accountNumber')]
    public string $accountNumber;

    /**
     * @var string $transitNumber Five-digit code that represents the customer's banking branch.
     */
    #[JsonProperty('transitNumber')]
    public string $transitNumber;

    /**
     * @var string $institutionNumber Three-digit code that represents the customer's bank.
     */
    #[JsonProperty('institutionNumber')]
    public string $institutionNumber;

    /**
     * @var ?SecureTokenSummary $secureToken
     */
    #[JsonProperty('secureToken')]
    public ?SecureTokenSummary $secureToken;

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   transitNumber: string,
     *   institutionNumber: string,
     *   secureToken?: ?SecureTokenSummary,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->accountNumber = $values['accountNumber'];
        $this->transitNumber = $values['transitNumber'];
        $this->institutionNumber = $values['institutionNumber'];
        $this->secureToken = $values['secureToken'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
