<?php

namespace Payroc\CardPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\CardPayments\Refunds\Types\UnreferencedRefundChannel;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\RefundOrder;
use Payroc\Types\Customer;
use Payroc\Types\IpAddress;
use Payroc\CardPayments\Refunds\Types\UnreferencedRefundRefundMethod;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class UnreferencedRefund extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var value-of<UnreferencedRefundChannel> $channel Channel that the merchant used to request the refund.
     */
    #[JsonProperty('channel')]
    public string $channel;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var RefundOrder $order
     */
    #[JsonProperty('order')]
    public RefundOrder $order;

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
     * @var UnreferencedRefundRefundMethod $refundMethod Object that contains information about how the merchant refunds the customer.
     */
    #[JsonProperty('refundMethod')]
    public UnreferencedRefundRefundMethod $refundMethod;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   channel: value-of<UnreferencedRefundChannel>,
     *   processingTerminalId: string,
     *   order: RefundOrder,
     *   refundMethod: UnreferencedRefundRefundMethod,
     *   operator?: ?string,
     *   customer?: ?Customer,
     *   ipAddress?: ?IpAddress,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->channel = $values['channel'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->ipAddress = $values['ipAddress'] ?? null;
        $this->refundMethod = $values['refundMethod'];
        $this->customFields = $values['customFields'] ?? null;
    }
}
