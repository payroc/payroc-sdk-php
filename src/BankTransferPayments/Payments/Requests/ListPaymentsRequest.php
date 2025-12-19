<?php

namespace Payroc\BankTransferPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\BankTransferPayments\Payments\Types\ListPaymentsRequestTypeItem;
use Payroc\BankTransferPayments\Payments\Types\ListPaymentsRequestStatusItem;
use DateTime;
use Payroc\BankTransferPayments\Payments\Types\ListPaymentsRequestSettlementState;

class ListPaymentsRequest extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Filter results by the unique identifier that we assigned to the terminal.
     */
    public string $processingTerminalId;

    /**
     * @var ?string $orderId Filter results by the order ID of the payment.
     */
    public ?string $orderId;

    /**
     * @var ?string $nameOnAccount Filter results by the account holder's name.
     */
    public ?string $nameOnAccount;

    /**
     * @var ?string $last4 Filter results by the last four digits of the account number.
     */
    public ?string $last4;

    /**
     * @var ?array<value-of<ListPaymentsRequestTypeItem>> $type Filter results by transaction type.
     */
    public ?array $type;

    /**
     * @var ?array<value-of<ListPaymentsRequestStatusItem>> $status Filter results by the status of the payment.
     */
    public ?array $status;

    /**
     * @var ?DateTime $dateFrom Filter results by payments that the merchant ran after a specific date. The value follows the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) standard.
     */
    public ?DateTime $dateFrom;

    /**
     * @var ?DateTime $dateTo Filter results by payments that the merchant ran before a specific date. The value follows the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) standard.
     */
    public ?DateTime $dateTo;

    /**
     * @var ?value-of<ListPaymentsRequestSettlementState> $settlementState Filter results by the settlement status.
     */
    public ?string $settlementState;

    /**
     * @var ?DateTime $settlementDate Filter results by the settlement date. Send a value in **YYYY-MM-DD** format.
     */
    public ?DateTime $settlementDate;

    /**
     * @var ?string $paymentLinkId Filter results by the paymentLinkId.
     */
    public ?string $paymentLinkId;

    /**
     * Return the previous page of results before the value that you specify.
     *
     * You can’t send the before parameter in the same request as the after parameter.
     *
     * @var ?string $before
     */
    public ?string $before;

    /**
     * Return the next page of results after the value that you specify.
     *
     * You can’t send the after parameter in the same request as the before parameter.
     *
     * @var ?string $after
     */
    public ?string $after;

    /**
     * @var ?int $limit Limit the maximum number of results that we return for each page.
     */
    public ?int $limit;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   orderId?: ?string,
     *   nameOnAccount?: ?string,
     *   last4?: ?string,
     *   type?: ?array<value-of<ListPaymentsRequestTypeItem>>,
     *   status?: ?array<value-of<ListPaymentsRequestStatusItem>>,
     *   dateFrom?: ?DateTime,
     *   dateTo?: ?DateTime,
     *   settlementState?: ?value-of<ListPaymentsRequestSettlementState>,
     *   settlementDate?: ?DateTime,
     *   paymentLinkId?: ?string,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->orderId = $values['orderId'] ?? null;
        $this->nameOnAccount = $values['nameOnAccount'] ?? null;
        $this->last4 = $values['last4'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->dateFrom = $values['dateFrom'] ?? null;
        $this->dateTo = $values['dateTo'] ?? null;
        $this->settlementState = $values['settlementState'] ?? null;
        $this->settlementDate = $values['settlementDate'] ?? null;
        $this->paymentLinkId = $values['paymentLinkId'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
