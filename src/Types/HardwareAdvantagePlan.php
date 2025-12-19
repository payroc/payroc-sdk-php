<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the Hardware Advantage Plan.
 */
class HardwareAdvantagePlan extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the merchant has signed up for the Hardware Advantage Plan.
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
