<?php

namespace Payroc\PayrocCloud\Signatures\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

class RetrieveSignaturesResponse extends JsonSerializableType
{
    /**
     * @var ?string $signatureId Unique identifier that we assigned to the signature.
     */
    #[JsonProperty('signatureId')]
    public ?string $signatureId;

    /**
     * @var ?string $processingTerminalId Unique identifier of the terminal that the signature is linked to.
     */
    #[JsonProperty('processingTerminalId')]
    public ?string $processingTerminalId;

    /**
     * @var ?DateTime $createdOn Date that the device captured the signature. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdOn'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdOn;

    /**
     * @var ?string $contentType MIME type that indicates the format of the image file.
     */
    #[JsonProperty('contentType')]
    public ?string $contentType;

    /**
     * @var ?string $signature Image data for the signature. Our gateway returns the signature as a Base64-encoded value.
     */
    #[JsonProperty('signature')]
    public ?string $signature;

    /**
     * @param array{
     *   signatureId?: ?string,
     *   processingTerminalId?: ?string,
     *   createdOn?: ?DateTime,
     *   contentType?: ?string,
     *   signature?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->signatureId = $values['signatureId'] ?? null;
        $this->processingTerminalId = $values['processingTerminalId'] ?? null;
        $this->createdOn = $values['createdOn'] ?? null;
        $this->contentType = $values['contentType'] ?? null;
        $this->signature = $values['signature'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
