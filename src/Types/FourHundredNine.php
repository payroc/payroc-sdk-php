<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class FourHundredNine extends JsonSerializableType
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
     * @var ?string $instance Resource path to the existing resource
     */
    #[JsonProperty('instance')]
    public ?string $instance;

    /**
     * @var ?array<FourHundredNineErrorsItem> $errors
     */
    #[JsonProperty('errors'), ArrayType([FourHundredNineErrorsItem::class])]
    public ?array $errors;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   type: string,
     *   title: string,
     *   status: int,
     *   detail: string,
     *   instance?: ?string,
     *   errors?: ?array<FourHundredNineErrorsItem>,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->title = $values['title'];
        $this->status = $values['status'];
        $this->detail = $values['detail'];
        $this->instance = $values['instance'] ?? null;
        $this->errors = $values['errors'] ?? null;
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
