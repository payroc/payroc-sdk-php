<?php

namespace Payroc\PayrocCloud\RefundInstructions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\RefundInstructionOrder;
use Payroc\Types\Customer;
use Payroc\Types\IpAddress;
use Payroc\Types\CustomizationOptions;

class RefundInstructionRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var RefundInstructionOrder $order
     */
    #[JsonProperty('order')]
    public RefundInstructionOrder $order;

    /**
     * @var ?Customer $customer
     */
    #[JsonProperty('customer')]
    public ?Customer $customer;

    /**
     * @var ?IpAddress $ipAddress
     */
    #[JsonProperty('ipAddress')]
    public ?IpAddress $ipAddress;

    /**
     * @var ?CustomizationOptions $customizationOptions
     */
    #[JsonProperty('customizationOptions')]
    public ?CustomizationOptions $customizationOptions;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId: string,
     *   order: RefundInstructionOrder,
     *   operator?: ?string,
     *   customer?: ?Customer,
     *   ipAddress?: ?IpAddress,
     *   customizationOptions?: ?CustomizationOptions,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->operator = $values['operator'] ?? null;
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->ipAddress = $values['ipAddress'] ?? null;
        $this->customizationOptions = $values['customizationOptions'] ?? null;
    }
}
