<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\DeviceInstruction;
use Payroc\Core\Json\JsonProperty;

class PaymentInstruction extends JsonSerializableType
{
    use DeviceInstruction;

    /**
     * @var ?string $paymentInstructionId Unique identifier that we assigned to the payment instruction.
     */
    #[JsonProperty('paymentInstructionId')]
    public ?string $paymentInstructionId;

    /**
     * @param array{
     *   status?: ?value-of<DeviceInstructionStatus>,
     *   errorMessage?: ?string,
     *   link?: ?Link,
     *   paymentInstructionId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->errorMessage = $values['errorMessage'] ?? null;
        $this->link = $values['link'] ?? null;
        $this->paymentInstructionId = $values['paymentInstructionId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
