<?php

namespace Payroc\Attachments\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class Attachment extends JsonSerializableType
{
    /**
     * @var string $attachmentId Unique identifier that our gateway assigned to the attachment.
     */
    #[JsonProperty('attachmentId')]
    public string $attachmentId;

    /**
     * @var value-of<AttachmentType> $type Type of attachment.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * Upload status of the attachment. The value is one of the following:
     * - `pending` - We have not yet uploaded the attachment.
     * - `accepted` - We have uploaded the attachment.
     * - `rejected` - We rejected the attachment.
     *
     * @var value-of<AttachmentUploadStatus> $uploadStatus
     */
    #[JsonProperty('uploadStatus')]
    public string $uploadStatus;

    /**
     * @var string $fileName Name of the file.
     */
    #[JsonProperty('fileName')]
    public string $fileName;

    /**
     * @var string $contentType Content type of the file.
     */
    #[JsonProperty('contentType')]
    public string $contentType;

    /**
     * @var ?string $description Short description of the attachment.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var AttachmentEntity $entity Object that contains information about the entity that the attachment is linked to.
     */
    #[JsonProperty('entity')]
    public AttachmentEntity $entity;

    /**
     * @var DateTime $createdDate Date and time that we received your request to upload the attachment.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public DateTime $createdDate;

    /**
     * @var DateTime $lastModifiedDate Date and time the attachment was last modified.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATETIME)]
    public DateTime $lastModifiedDate;

    /**
     * @var ?array<string, string> $metadata Object that you can send to include custom metadata in the request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @param array{
     *   attachmentId: string,
     *   type: value-of<AttachmentType>,
     *   uploadStatus: value-of<AttachmentUploadStatus>,
     *   fileName: string,
     *   contentType: string,
     *   entity: AttachmentEntity,
     *   createdDate: DateTime,
     *   lastModifiedDate: DateTime,
     *   description?: ?string,
     *   metadata?: ?array<string, string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->attachmentId = $values['attachmentId'];
        $this->type = $values['type'];
        $this->uploadStatus = $values['uploadStatus'];
        $this->fileName = $values['fileName'];
        $this->contentType = $values['contentType'];
        $this->description = $values['description'] ?? null;
        $this->entity = $values['entity'];
        $this->createdDate = $values['createdDate'];
        $this->lastModifiedDate = $values['lastModifiedDate'];
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
