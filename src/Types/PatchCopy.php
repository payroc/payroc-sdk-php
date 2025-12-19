<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * A Patch Copy Operation.
 */
class PatchCopy extends JsonSerializableType
{
    /**
     * Location of the value that you want to copy.
     * The format for this value is JSON Pointer.
     *
     * @var string $from
     */
    #[JsonProperty('from')]
    public string $from;

    /**
     * Location where you want to copy the value to.
     * The format for this value is JSON Pointer.
     *
     * @var string $path
     */
    #[JsonProperty('path')]
    public string $path;

    /**
     * @param array{
     *   from: string,
     *   path: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->from = $values['from'];
        $this->path = $values['path'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
