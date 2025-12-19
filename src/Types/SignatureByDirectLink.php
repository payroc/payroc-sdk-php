<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains signature information if we captured the merchant’s signature by direct link.
 */
class SignatureByDirectLink extends JsonSerializableType
{
    /**
     * @var ?Link $link Object that contains links to the signed contract.
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
