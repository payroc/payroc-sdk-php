<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains details about EBT transactions.
 */
class EbtDisabled extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the terminal accepts Electronic Benefit Transfer (EBT) transactions.
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
