<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the configuration of the POS terminal.
 */
class DeviceConfig extends JsonSerializableType
{
    /**
     * @var bool $quickChip Indicates if Quick Chip mode is active on a merchant’s POS terminal.
     */
    #[JsonProperty('quickChip')]
    public bool $quickChip;

    /**
     * @param array{
     *   quickChip: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->quickChip = $values['quickChip'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
