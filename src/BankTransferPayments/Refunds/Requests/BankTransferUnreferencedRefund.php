<?php

namespace Payroc\BankTransferPayments\Refunds\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\BankTransferRefundOrder;
use Payroc\Types\BankTransferCustomer;
use Payroc\BankTransferPayments\Refunds\Types\BankTransferUnreferencedRefundRefundMethod;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class BankTransferUnreferencedRefund extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var BankTransferRefundOrder $order
     */
    #[JsonProperty('order')]
    public BankTransferRefundOrder $order;

    /**
     * @var ?BankTransferCustomer $customer
     */
    #[JsonProperty('customer')]
    public ?BankTransferCustomer $customer;

    /**
     * @var BankTransferUnreferencedRefundRefundMethod $refundMethod Object that contains information about how the merchant refunds the customer.
     */
    #[JsonProperty('refundMethod')]
    public BankTransferUnreferencedRefundRefundMethod $refundMethod;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId: string,
     *   order: BankTransferRefundOrder,
     *   refundMethod: BankTransferUnreferencedRefundRefundMethod,
     *   customer?: ?BankTransferCustomer,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->refundMethod = $values['refundMethod'];
        $this->customFields = $values['customFields'] ?? null;
    }
}
