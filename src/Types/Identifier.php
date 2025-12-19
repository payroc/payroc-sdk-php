<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class Identifier extends JsonSerializableType
{
    /**
     * @var value-of<IdentifierType> $type Type of ID provided to verify identity.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $value Social Security Number (SSN) or Social Insurance Number (SIN).
     */
    #[JsonProperty('value')]
    public string $value;

    /**
     * @param array{
     *   type: value-of<IdentifierType>,
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
