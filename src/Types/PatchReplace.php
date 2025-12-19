<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * A Patch Replace Operation.
 */
class PatchReplace extends JsonSerializableType
{
    /**
     * Location of the value that you want to replace.
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
