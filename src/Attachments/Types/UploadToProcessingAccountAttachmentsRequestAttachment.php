<?php

namespace Payroc\Attachments\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains details about the attachment.
 */
class UploadToProcessingAccountAttachmentsRequestAttachment extends JsonSerializableType
{
    /**
     * @var value-of<UploadToProcessingAccountAttachmentsRequestAttachmentType> $type Type of attachment.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var ?string $description Short description of the attachment.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?array<string, string> $metadata Object that you can send to include custom metadata in the request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @param array{
     *   type: value-of<UploadToProcessingAccountAttachmentsRequestAttachmentType>,
     *   description?: ?string,
     *   metadata?: ?array<string, string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->description = $values['description'] ?? null;
        $this->metadata = $values['metadata'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
