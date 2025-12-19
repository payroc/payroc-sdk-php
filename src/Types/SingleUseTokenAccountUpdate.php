<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the token.
 */
class SingleUseTokenAccountUpdate extends JsonSerializableType
{
    /**
     * @var string $token Single-use token that the gateway assigned to the payment details.
     */
    #[JsonProperty('token')]
    public string $token;

    /**
     * @param array{
     *   token: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->token = $values['token'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
