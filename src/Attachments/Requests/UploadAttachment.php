<?php

namespace Payroc\Attachments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Attachments\Types\UploadToProcessingAccountAttachmentsRequestAttachment;
use Payroc\Core\Json\JsonProperty;
use Payroc\Utils\File;

class UploadAttachment extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var UploadToProcessingAccountAttachmentsRequestAttachment $attachment Object that contains details about the attachment.
     */
    #[JsonProperty('attachment')]
    public UploadToProcessingAccountAttachmentsRequestAttachment $attachment;

    /**
     * @var File $file
     */
    public File $file;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   attachment: UploadToProcessingAccountAttachmentsRequestAttachment,
     *   file: File,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->attachment = $values['attachment'];
        $this->file = $values['file'];
    }
}
