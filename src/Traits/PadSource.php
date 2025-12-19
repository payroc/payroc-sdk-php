<?php

namespace Payroc\Traits;

use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's account details.
 *
 * @property string $nameOnAccount
 * @property string $accountNumber
 * @property string $transitNumber
 * @property string $institutionNumber
 */
trait PadSource
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
}
