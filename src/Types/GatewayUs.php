<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the gateway fees.
 */
class GatewayUs extends JsonSerializableType
{
    /**
     * @var GatewayUsFees $fees Object that contains information about the gateway fees.
     */
    #[JsonProperty('fees')]
    public GatewayUsFees $fees;

    /**
     * @param array{
     *   fees: GatewayUsFees,
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
