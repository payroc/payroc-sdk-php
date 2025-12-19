<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * A Patch Add Operation.
 */
class PatchAdd extends JsonSerializableType
{
    /**
     * Location where you want to add the value.
     * The format for this value is JSON Pointer.
     *
     * @var string $path
     */
    #[JsonProperty('path')]
    public string $path;

    /**
     * @var mixed $value
     */
    #[JsonProperty('value')]
    public mixed $value;

    /**
     * @param array{
     *   path: string,
     *   value: mixed,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->path = $values['path'];
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
