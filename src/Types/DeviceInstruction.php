<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the status of the instruction
 */
class DeviceInstruction extends JsonSerializableType
{
    /**
     * Indicates the current status of the instruction.
     * - `canceled` – The instruction was canceled before it was completed.
     * - `completed` – The instruction has completed. Use the link object to check the resource.
     * - `failure` – The instruction failed. Check the errorMessage field for more information.
     * - `inProgress` – The instruction is currently in progress.
     *
     * @var ?value-of<DeviceInstructionStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * Description of the error that caused the instruction to fail.
     *
     * **Note:** We return this field only if the status is `failure`.
     *
     * @var ?string $errorMessage
     */
    #[JsonProperty('errorMessage')]
    public ?string $errorMessage;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   status?: ?value-of<DeviceInstructionStatus>,
     *   errorMessage?: ?string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->errorMessage = $values['errorMessage'] ?? null;
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
