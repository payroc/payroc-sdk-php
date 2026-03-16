<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the gateway fees for MPA 5.2.
 */
class GatewayUs52 extends JsonSerializableType
{
    /**
     * @var GatewayUs52Fees $fees Object that contains information about the gateway fees.
     */
    #[JsonProperty('fees')]
    public GatewayUs52Fees $fees;

    /**
     * @param array{
     *   fees: GatewayUs52Fees,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fees = $values['fees'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
