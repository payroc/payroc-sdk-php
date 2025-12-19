<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the gateway fees.
 */
class GatewayUs50Fees extends JsonSerializableType
{
    /**
     * @var int $monthly Monthly fee for the gateway. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('monthly')]
    public int $monthly;

    /**
     * @var int $setup Fee for setting up your account with the gateway. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('setup')]
    public int $setup;

    /**
     * @var int $perTransaction Fee for each transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('perTransaction')]
    public int $perTransaction;

    /**
     * @var int $perDeviceMonthly Monthly fee for each device. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('perDeviceMonthly')]
    public int $perDeviceMonthly;

    /**
     * @param array{
     *   monthly: int,
     *   setup: int,
     *   perTransaction: int,
     *   perDeviceMonthly: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->monthly = $values['monthly'];
        $this->setup = $values['setup'];
        $this->perTransaction = $values['perTransaction'];
        $this->perDeviceMonthly = $values['perDeviceMonthly'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
