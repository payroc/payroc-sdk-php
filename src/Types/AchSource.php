<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's account details.
 */
class AchSource extends JsonSerializableType
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

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   routingNumber: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
