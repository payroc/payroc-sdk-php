<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the retrieved refund.
 */
class RetrievedRefund extends JsonSerializableType
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
     * @var ?string $operator Operator who requested the refund.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var RefundOrder $order
     */
    #[JsonProperty('order')]
    public RefundOrder $order;

    /**
     * @var ?RetrievedCustomer $customer
     */
    #[JsonProperty('customer')]
    public ?RetrievedCustomer $customer;

    /**
     * @var RetrievedCard $card
     */
    #[JsonProperty('card')]
    public RetrievedCard $card;

    /**
     * @var ?PaymentSummary $payment
     */
    #[JsonProperty('payment')]
    public ?PaymentSummary $payment;

    /**
     * @var ?array<value-of<SupportedOperationsItem>> $supportedOperations
     */
    #[JsonProperty('supportedOperations'), ArrayType(['string'])]
    public ?array $supportedOperations;

    /**
     * @var TransactionResult $transactionResult
     */
    #[JsonProperty('transactionResult')]
    public TransactionResult $transactionResult;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   refundId: string,
     *   processingTerminalId: string,
     *   order: RefundOrder,
     *   card: RetrievedCard,
     *   transactionResult: TransactionResult,
     *   operator?: ?string,
     *   customer?: ?RetrievedCustomer,
     *   payment?: ?PaymentSummary,
     *   supportedOperations?: ?array<value-of<SupportedOperationsItem>>,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->refundId = $values['refundId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->card = $values['card'];
        $this->payment = $values['payment'] ?? null;
        $this->supportedOperations = $values['supportedOperations'] ?? null;
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
