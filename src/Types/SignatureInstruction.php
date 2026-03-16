<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\DeviceInstruction;
use Payroc\Core\Json\JsonProperty;

class SignatureInstruction extends JsonSerializableType
{
    use DeviceInstruction;

    /**
     * @var string $signatureInstructionId Unique identifier that our gateway assigned to the instruction.
     */
    #[JsonProperty('signatureInstructionId')]
    public string $signatureInstructionId;

    /**
     * @param array{
     *   signatureInstructionId: string,
     *   status?: ?value-of<DeviceInstructionStatus>,
     *   errorMessage?: ?string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->status = $values['status'] ?? null;
        $this->errorMessage = $values['errorMessage'] ?? null;
        $this->link = $values['link'] ?? null;
        $this->signatureInstructionId = $values['signatureInstructionId'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
