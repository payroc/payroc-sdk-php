<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class BankTransferRefund extends JsonSerializableType
{
    /**
     * @var string $refundId Unique identifier that our gateway assigned to the refund.
     */
    #[JsonProperty('refundId')]
    public string $refundId;

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
     * @var BankTransferRefundBankAccount $bankAccount Object that contains information about the bank account.
     */
    #[JsonProperty('bankAccount')]
    public BankTransferRefundBankAccount $bankAccount;

    /**
     * @var ?PaymentSummary $payment
     */
    #[JsonProperty('payment')]
    public ?PaymentSummary $payment;

    /**
     * @var BankTransferResult $transactionResult
     */
    #[JsonProperty('transactionResult')]
    public BankTransferResult $transactionResult;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   refundId: string,
     *   processingTerminalId: string,
     *   order: BankTransferRefundOrder,
     *   bankAccount: BankTransferRefundBankAccount,
     *   transactionResult: BankTransferResult,
     *   customer?: ?BankTransferCustomer,
     *   payment?: ?PaymentSummary,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->refundId = $values['refundId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->bankAccount = $values['bankAccount'];
        $this->payment = $values['payment'] ?? null;
        $this->transactionResult = $values['transactionResult'];
        $this->customFields = $values['customFields'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
