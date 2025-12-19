<?php

namespace Payroc\Boarding\Owners\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\Owner;

class UpdateOwnersRequest extends JsonSerializableType
{
    /**
     * @var Owner $body
     */
    public Owner $body;

    /**
     * @param array{
     *   body: Owner,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
