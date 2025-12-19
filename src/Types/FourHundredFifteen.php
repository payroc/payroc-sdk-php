<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FourHundredFifteen extends JsonSerializableType
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
     * @param array{
     *   type: string,
     *   title: string,
     *   status: int,
     *   detail: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->title = $values['title'];
        $this->status = $values['status'];
        $this->detail = $values['detail'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
