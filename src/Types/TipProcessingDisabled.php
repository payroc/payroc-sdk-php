<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Tip settings
 */
class TipProcessingDisabled extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the terminal can accept tips.
     */
    #[JsonProperty('enabled')]
    public bool $enabled;

    /**
     * @param array{
     *   enabled: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->enabled = $values['enabled'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
