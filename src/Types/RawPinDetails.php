<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the unencrypted PIN details.
 */
class RawPinDetails extends JsonSerializableType
{
    /**
     * @var string $pin Customer’s unencrypted PIN.
     */
    #[JsonProperty('pin')]
    public string $pin;

    /**
     * @param array{
     *   pin: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->pin = $values['pin'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
