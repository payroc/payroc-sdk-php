<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FourHundredNineErrorsItem extends JsonSerializableType
{
    /**
     * @var ?string $parameter The parameter or field causing the issues
     */
    #[JsonProperty('parameter')]
    public ?string $parameter;

    /**
     * @var ?string $detail Short detail of the validation errors
     */
    #[JsonProperty('detail')]
    public ?string $detail;

    /**
     * @var ?string $message Error message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @param array{
     *   parameter?: ?string,
     *   detail?: ?string,
     *   message?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->parameter = $values['parameter'] ?? null;
        $this->detail = $values['detail'] ?? null;
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
