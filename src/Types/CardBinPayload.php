<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the card's bank identification number (BIN).
 */
class CardBinPayload extends JsonSerializableType
{
    /**
     * @var string $bin
     */
    #[JsonProperty('bin')]
    public string $bin;

    /**
     * @param array{
     *   bin: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->bin = $values['bin'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
