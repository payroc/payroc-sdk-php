<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class Payment extends JsonSerializableType
{
    /**
     * @var string $paymentId Unique identifier that our gateway assigned to the transaction.
     */
    #[JsonProperty('paymentId')]
    public string $paymentId;

    /**
     * @var string $processingTerminalId Unique identifier of the terminal that initiated the transaction.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var PaymentOrder $order
     */
    #[JsonProperty('order')]
    public PaymentOrder $order;

    /**
     * @var ?RetrievedCustomer $customer
     */
    #[JsonProperty('customer')]
    public ?RetrievedCustomer $customer;

    /**
     * @var Card $card
     */
    #[JsonProperty('card')]
    public Card $card;

    /**
     * Array of refundSummary objects.
     * Each object contains information about refunds linked to the transaction.
     *
     * @var ?array<RefundSummary> $refunds
     */
    #[JsonProperty('refunds'), ArrayType([RefundSummary::class])]
    public ?array $refunds;

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
     *   paymentId: string,
     *   processingTerminalId: string,
     *   order: PaymentOrder,
     *   card: Card,
     *   transactionResult: TransactionResult,
     *   operator?: ?string,
     *   customer?: ?RetrievedCustomer,
     *   refunds?: ?array<RefundSummary>,
     *   supportedOperations?: ?array<value-of<SupportedOperationsItem>>,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentId = $values['paymentId'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->card = $values['card'];
        $this->refunds = $values['refunds'] ?? null;
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
