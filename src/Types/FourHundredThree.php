<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FourHundredThree extends JsonSerializableType
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
     * @var ?string $instance Resource path the action was attempted on
     */
    #[JsonProperty('instance')]
    public ?string $instance;

    /**
     * @var ?string $resource Resource the action was attempted on
     */
    #[JsonProperty('resource')]
    public ?string $resource;

    /**
     * @param array{
     *   type: string,
     *   title: string,
     *   status: int,
     *   detail: string,
     *   instance?: ?string,
     *   resource?: ?string,
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
        $this->resource = $values['resource'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
