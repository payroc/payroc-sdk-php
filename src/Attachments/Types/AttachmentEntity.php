<?php

namespace Payroc\Attachments\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the entity that the attachment is linked to.
 */
class AttachmentEntity extends JsonSerializableType
{
    /**
     * @var value-of<AttachmentEntityType> $type Type of entity that the attachment is linked to.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $id Unique identifier of the entity that the attachment is linked to.
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @param array{
     *   type: value-of<AttachmentEntityType>,
     *   id: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->id = $values['id'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
