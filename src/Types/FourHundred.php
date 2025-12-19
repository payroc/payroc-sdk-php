<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class FourHundred extends JsonSerializableType
{
    /**
     * @var string $type URI reference identifying the problem type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $title Short description of the issue.
     */
    #[JsonProperty('title')]
    public string $title;

    /**
     * @var int $status Http status code
     */
    #[JsonProperty('status')]
    public int $status;

    /**
     * @var string $detail Explanation of the problem
     */
    #[JsonProperty('detail')]
    public string $detail;

    /**
     * @var ?array<FourHundredErrorsItem> $errors
     */
    #[JsonProperty('errors'), ArrayType([FourHundredErrorsItem::class])]
    public ?array $errors;

    /**
     * @param array{
     *   type: string,
     *   title: string,
     *   status: int,
     *   detail: string,
     *   errors?: ?array<FourHundredErrorsItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->title = $values['title'];
        $this->status = $values['status'];
        $this->detail = $values['detail'];
        $this->errors = $values['errors'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
