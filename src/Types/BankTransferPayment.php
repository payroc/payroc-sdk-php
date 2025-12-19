<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the sale and the customer's bank details.
 */
class BankTransferPayment extends JsonSerializableType
{
    /**
     * @var string $paymentId Unique identifier that we assigned to the payment.
     */
    #[JsonProperty('paymentId')]
    public string $paymentId;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var BankTransferPaymentOrder $order
     */
    #[JsonProperty('order')]
    public BankTransferPaymentOrder $order;

    /**
     * @var ?BankTransferCustomer $customer
     */
    #[JsonProperty('customer')]
    public ?BankTransferCustomer $customer;

    /**
     * @var BankTransferPaymentBankAccount $bankAccount Object that contains information about the bank account.
     */
    #[JsonProperty('bankAccount')]
    public BankTransferPaymentBankAccount $bankAccount;

    /**
     * @var ?array<RefundSummary> $refunds List of refunds issued against the payment.
     */
    #[JsonProperty('refunds'), ArrayType([RefundSummary::class])]
    public ?array $refunds;

    /**
     * @var ?array<BankTransferReturnSummary> $returns List of returns issued against the payment.
     */
    #[JsonProperty('returns'), ArrayType([BankTransferReturnSummary::class])]
    public ?array $returns;

    /**
     * @var ?PaymentSummary $representment List of re-presented payments linked to the return.
     */
    #[JsonProperty('representment')]
    public ?PaymentSummary $representment;

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
     *   paymentId: string,
     *   processingTerminalId: string,
     *   order: BankTransferPaymentOrder,
     *   bankAccount: BankTransferPaymentBankAccount,
     *   transactionResult: BankTransferResult,
     *   customer?: ?BankTransferCustomer,
     *   refunds?: ?array<RefundSummary>,
     *   returns?: ?array<BankTransferReturnSummary>,
     *   representment?: ?PaymentSummary,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentId = $values['paymentId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->bankAccount = $values['bankAccount'];
        $this->refunds = $values['refunds'] ?? null;
        $this->returns = $values['returns'] ?? null;
        $this->representment = $values['representment'] ?? null;
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
