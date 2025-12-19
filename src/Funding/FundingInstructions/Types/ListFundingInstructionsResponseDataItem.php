<?php

namespace Payroc\Funding\FundingInstructions\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\Instruction;
use Payroc\Types\Link;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\InstructionStatus;
use Payroc\Types\InstructionMerchantsItem;

class ListFundingInstructionsResponseDataItem extends JsonSerializableType
{
    use Instruction;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   instructionId?: ?int,
     *   createdDate?: ?string,
     *   lastModifiedDate?: ?string,
     *   status?: ?value-of<InstructionStatus>,
     *   merchants?: ?array<InstructionMerchantsItem>,
     *   metadata?: ?array<string, string>,
     *   link?: ?Link,
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
