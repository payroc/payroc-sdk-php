<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Inform the payfac what to do with the specified funds. **
 */
class Instruction extends JsonSerializableType
{
    /**
     * @var ?int $instructionId Unique identifier that we assigned to the funding instruction.
     */
    #[JsonProperty('instructionId')]
    public ?int $instructionId;

    /**
     * @var ?string $createdDate Date that we created the funding instruction. The date format follows the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) standard.
     */
    #[JsonProperty('createdDate')]
    public ?string $createdDate;

    /**
     * @var ?string $lastModifiedDate Date of the most recent change to the funding instruction. The date format follows the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) standard.
     */
    #[JsonProperty('lastModifiedDate')]
    public ?string $lastModifiedDate;

    /**
     * Status of the funding instruction. Our gateway returns one of the following values:
     * - `accepted` - We have received the funding instruction but have not yet reviewed it.
     * - `pending` - We have received the funding instruction and we are reviewing it.
     * - `completed` - We have reviewed and processed the funding instruction.
     *
     * @var ?value-of<InstructionStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?array<InstructionMerchantsItem> $merchants Array of merchants objects. Each object specifies the merchant whose funding balance we distribute and who you want to send the funds to.
     */
    #[JsonProperty('merchants'), ArrayType([InstructionMerchantsItem::class])]
    public ?array $merchants;

    /**
     * @var ?array<string, string> $metadata [Metadata](https://docs.payroc.com/api/metadata) object you can use to include custom data with your request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @param array{
     *   instructionId?: ?int,
     *   createdDate?: ?string,
     *   lastModifiedDate?: ?string,
     *   status?: ?value-of<InstructionStatus>,
     *   merchants?: ?array<InstructionMerchantsItem>,
     *   metadata?: ?array<string, string>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->instructionId = $values['instructionId'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->merchants = $values['merchants'] ?? null;
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
