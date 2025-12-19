<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\DeviceInstruction;
use Payroc\Core\Json\JsonProperty;

class RefundInstruction extends JsonSerializableType
{
    use DeviceInstruction;

    /**
     * @var ?string $refundInstructionId Unique identifier that we assigned to the refund instruction.
     */
    #[JsonProperty('refundInstructionId')]
    public ?string $refundInstructionId;

    /**
     * @param array{
     *   status?: ?value-of<DeviceInstructionStatus>,
     *   errorMessage?: ?string,
     *   link?: ?Link,
     *   refundInstructionId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->errorMessage = $values['errorMessage'] ?? null;
        $this->link = $values['link'] ?? null;
        $this->refundInstructionId = $values['refundInstructionId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
