<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FiveHundredErrorsItem extends JsonSerializableType
{
    /**
     * @var ?string $message Error message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @param array{
     *   message?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->message = $values['message'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
