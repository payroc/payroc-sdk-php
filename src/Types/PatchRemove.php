<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * A Patch Remove Operation.
 */
class PatchRemove extends JsonSerializableType
{
    /**
     * Location of the value that you want to remove.
     * The format for this value is JSON Pointer.
     *
     * @var string $path
     */
    #[JsonProperty('path')]
    public string $path;

    /**
     * @param array{
     *   path: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
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
