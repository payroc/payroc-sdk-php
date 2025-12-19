<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's account details.
 */
class PadSource extends JsonSerializableType
{
    /**
     * @var string $nameOnAccount Customer's name.
     */
    #[JsonProperty('nameOnAccount')]
    public string $nameOnAccount;

    /**
     * @var string $accountNumber Customer's account number.
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
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   transitNumber: string,
     *   institutionNumber: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
