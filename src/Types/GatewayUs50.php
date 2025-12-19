<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the gateway fees for MPA 5.0.
 */
class GatewayUs50 extends JsonSerializableType
{
    /**
     * @var GatewayUs50Fees $fees Object that contains information about the gateway fees.
     */
    #[JsonProperty('fees')]
    public GatewayUs50Fees $fees;

    /**
     * @param array{
     *   fees: GatewayUs50Fees,
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
