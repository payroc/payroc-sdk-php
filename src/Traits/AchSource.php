<?php

namespace Payroc\Traits;

use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's account details.
 *
 * @property string $nameOnAccount
 * @property string $accountNumber
 * @property string $routingNumber
 */
trait AchSource
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
     * @var string $routingNumber Routing number of the customer's account.
     */
    #[JsonProperty('routingNumber')]
    public string $routingNumber;
}
