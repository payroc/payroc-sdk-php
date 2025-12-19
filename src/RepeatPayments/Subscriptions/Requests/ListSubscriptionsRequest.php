<?php

namespace Payroc\RepeatPayments\Subscriptions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\RepeatPayments\Subscriptions\Types\ListSubscriptionsRequestFrequency;
use Payroc\RepeatPayments\Subscriptions\Types\ListSubscriptionsRequestStatus;
use DateTime;

class ListSubscriptionsRequest extends JsonSerializableType
{
    /**
     * @var ?string $customerName Filter by the customer's name.
     */
    public ?string $customerName;

    /**
     * @var ?string $last4 Filter by the last four digits of the card or account number.
     */
    public ?string $last4;

    /**
     * @var ?string $paymentPlan Filter by the name of the payment plan.
     */
    public ?string $paymentPlan;

    /**
     * @var ?value-of<ListSubscriptionsRequestFrequency> $frequency Filter by the frequency of subscription payments.
     */
    public ?string $frequency;

    /**
     * @var ?value-of<ListSubscriptionsRequestStatus> $status Filter by the current status of the subscription.
     */
    public ?string $status;

    /**
     * Format: `YYYY-MM-DD`
     * Filter subscriptions that end on a specific date.
     *
     * @var ?DateTime $endDate
     */
    public ?DateTime $endDate;

    /**
     * Format: `YYYY-MM-DD`
     * Filter subscriptions by the date that the next payment is collected.
     *
     * @var ?DateTime $nextDueDate
     */
    public ?DateTime $nextDueDate;

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
     *   customerName?: ?string,
     *   last4?: ?string,
     *   paymentPlan?: ?string,
     *   frequency?: ?value-of<ListSubscriptionsRequestFrequency>,
     *   status?: ?value-of<ListSubscriptionsRequestStatus>,
     *   endDate?: ?DateTime,
     *   nextDueDate?: ?DateTime,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->customerName = $values['customerName'] ?? null;
        $this->last4 = $values['last4'] ?? null;
        $this->paymentPlan = $values['paymentPlan'] ?? null;
        $this->frequency = $values['frequency'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->endDate = $values['endDate'] ?? null;
        $this->nextDueDate = $values['nextDueDate'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
