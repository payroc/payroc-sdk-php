<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class ContactMethodEmail extends JsonSerializableType
{
    /**
     * @var string $value Email address.
     */
    #[JsonProperty('value')]
    public string $value;

    /**
     * @param array{
     *   value: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
