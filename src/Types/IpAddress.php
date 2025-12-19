<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the IP address of the device that sent the request.
 */
class IpAddress extends JsonSerializableType
{
    /**
     * @var value-of<IpAddressType> $type Internet protocol version of the IP address.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $value IP address of the device.
     */
    #[JsonProperty('value')]
    public string $value;

    /**
     * @param array{
     *   type: value-of<IpAddressType>,
     *   value: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->value = $values['value'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
