<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class CustomField extends JsonSerializableType
{
    /**
     * @var string $name Name of the custom field.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var string $value Value for the custom field.
     */
    #[JsonProperty('value')]
    public string $value;

    /**
     * @param array{
     *   name: string,
     *   value: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
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
