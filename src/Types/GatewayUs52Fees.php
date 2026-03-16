<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the gateway fees.
 */
class GatewayUs52Fees extends JsonSerializableType
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
     * @var ?int $_3DSecurePerTransaction Fee for each transaction which utilizes 3D Secure. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('3dSecurePerTransaction')]
    public ?int $_3DSecurePerTransaction;

    /**
     * @var ?int $tapToPayPerTransaction Fee for each tap to pay transaction. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('tapToPayPerTransaction')]
    public ?int $tapToPayPerTransaction;

    /**
     * @param array{
     *   monthly: int,
     *   setup: int,
     *   perTransaction: int,
     *   perDeviceMonthly: int,
     *   _3DSecurePerTransaction?: ?int,
     *   tapToPayPerTransaction?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->monthly = $values['monthly'];
        $this->setup = $values['setup'];
        $this->perTransaction = $values['perTransaction'];
        $this->perDeviceMonthly = $values['perDeviceMonthly'];
        $this->_3DSecurePerTransaction = $values['_3DSecurePerTransaction'] ?? null;
        $this->tapToPayPerTransaction = $values['tapToPayPerTransaction'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
