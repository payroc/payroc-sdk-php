<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the funding account.
 */
class PaymentMethodAchValue extends JsonSerializableType
{
    /**
     * @var string $routingNumber Routing number of the funding account.
     */
    #[JsonProperty('routingNumber')]
    public string $routingNumber;

    /**
     * @var string $accountNumber Account number of the funding account.
     */
    #[JsonProperty('accountNumber')]
    public string $accountNumber;

    /**
     * @param array{
     *   routingNumber: string,
     *   accountNumber: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->routingNumber = $values['routingNumber'];
        $this->accountNumber = $values['accountNumber'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
