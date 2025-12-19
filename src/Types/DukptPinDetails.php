<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about encrypted PIN details.
 */
class DukptPinDetails extends JsonSerializableType
{
    /**
     * Encrypted PIN.
     * **Note:** PIN is encrypted using the DUKPT scheme.
     *
     * @var string $pin
     */
    #[JsonProperty('pin')]
    public string $pin;

    /**
     * @var string $pinKsn Key serial number.
     */
    #[JsonProperty('pinKsn')]
    public string $pinKsn;

    /**
     * @param array{
     *   pin: string,
     *   pinKsn: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->pin = $values['pin'];
        $this->pinKsn = $values['pinKsn'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
