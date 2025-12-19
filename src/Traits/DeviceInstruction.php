<?php

namespace Payroc\Traits;

use Payroc\Types\DeviceInstructionStatus;
use Payroc\Types\Link;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the status of the instruction
 *
 * @property ?value-of<DeviceInstructionStatus> $status
 * @property ?string $errorMessage
 * @property ?Link $link
 */
trait DeviceInstruction
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
}
