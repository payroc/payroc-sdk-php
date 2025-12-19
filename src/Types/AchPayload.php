<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the payment details for the customer’s automated clearing house (ACH) transactions.
 */
class AchPayload extends JsonSerializableType
{
    /**
     * Indicates the customer’s account type.
     *
     * **Note:** For bank account details, send a value for accountType.
     *
     * @var ?value-of<AchPayloadAccountType> $accountType
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * Indicates how the customer authorized the ACH transaction. Send one of the following values:
     *
     * - `web` – Online transaction.
     * - `tel` – Telephone transaction.
     * - `ccd` – Corporate credit card or debit card transaction.
     * - `ppd` – Pre-arranged transaction.
     *
     * @var ?value-of<AchPayloadSecCode> $secCode
     */
    #[JsonProperty('secCode')]
    public ?string $secCode;

    /**
     * @var string $nameOnAccount Customer's name.
     */
    #[JsonProperty('nameOnAccount')]
    public string $nameOnAccount;

    /**
     * Customer’s bank account number.
     * **Note:** In responses, our gateway shows only the last four digits of the account number, for example, `*****5929`.
     *
     * @var string $accountNumber
     */
    #[JsonProperty('accountNumber')]
    public string $accountNumber;

    /**
     * @var string $routingNumber Nine-digit number that identifies the customer's bank.
     */
    #[JsonProperty('routingNumber')]
    public string $routingNumber;

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   routingNumber: string,
     *   accountType?: ?value-of<AchPayloadAccountType>,
     *   secCode?: ?value-of<AchPayloadSecCode>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountType = $values['accountType'] ?? null;
        $this->secCode = $values['secCode'] ?? null;
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->accountNumber = $values['accountNumber'];
        $this->routingNumber = $values['routingNumber'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
