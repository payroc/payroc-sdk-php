<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's account details.
 */
class AchBankAccount extends JsonSerializableType
{
    /**
     * Indicates the type of authorization for the transaction.
     *
     * **Note:** The field is mandatory for ACH secure token.
     *
     * - `web` – Online transaction.
     * - `tel` – Telephone transaction.
     * - `ccd` – Corporate credit card or debit card transaction.
     * - `ppd` – Pre-arranged transaction.
     *
     * @var ?value-of<AchBankAccountSecCode> $secCode
     */
    #[JsonProperty('secCode')]
    public ?string $secCode;

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
     * Routing number of the customer’s account.
     *
     * **Note:** In responses, our gateway shows only the last four digits of the account's routing number, for example, *****4162.
     *
     * @var string $routingNumber
     */
    #[JsonProperty('routingNumber')]
    public string $routingNumber;

    /**
     * @var ?SecureTokenSummary $secureToken
     */
    #[JsonProperty('secureToken')]
    public ?SecureTokenSummary $secureToken;

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   routingNumber: string,
     *   secCode?: ?value-of<AchBankAccountSecCode>,
     *   secureToken?: ?SecureTokenSummary,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->secCode = $values['secCode'] ?? null;
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->accountNumber = $values['accountNumber'];
        $this->routingNumber = $values['routingNumber'];
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
