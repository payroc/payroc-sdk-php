<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * A Patch Test Operation.
 */
class PatchTest extends JsonSerializableType
{
    /**
     * Location of the value that you want to test.
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
