<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the EMV tag.
 */
class EmvTag extends JsonSerializableType
{
    /**
     * @var string $hex Hex code of the EMV tag.
     */
    #[JsonProperty('hex')]
    public string $hex;

    /**
     * @var string $value Value of the EMV tag.
     */
    #[JsonProperty('value')]
    public string $value;

    /**
     * @param array{
     *   hex: string,
     *   value: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->hex = $values['hex'];
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
