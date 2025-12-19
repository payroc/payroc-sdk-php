<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the 3-D Secure information from our gateway.
 */
class GatewayThreeDSecure extends JsonSerializableType
{
    /**
     * @var string $mpiReference Reference that our gateway assigned to the 3-D Secure authentication response.
     */
    #[JsonProperty('mpiReference')]
    public string $mpiReference;

    /**
     * @param array{
     *   mpiReference: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->mpiReference = $values['mpiReference'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
