<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * A snapshot of the subscription's current state.
 */
class SubscriptionState extends JsonSerializableType
{
    /**
     * Status of the Subscription.
     *
     * - 'active' - Subscription is active.
     * - 'completed' - Subscription has reached the end date or the total number of billing cycles.
     * - 'cancelled' - Merchant deactivated the subscription.
     * - 'suspended' - Subscription is suspended. For example, if the customer misses payments.
     *
     * @var value-of<SubscriptionStateStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?DateTime $nextDueDate Date that the merchant collects the next payment.
     */
    #[JsonProperty('nextDueDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $nextDueDate;

    /**
     * @var int $paidInvoices Number of payments that the merchant has collected.
     */
    #[JsonProperty('paidInvoices')]
    public int $paidInvoices;

    /**
     * Number of payments until the end of the subscription.
     * Our gateway returns a value for **outstandingInvoices** only if the subscription
     * has an end date or a fixed number of billing cycles.
     *
     * @var ?int $outstandingInvoices
     */
    #[JsonProperty('outstandingInvoices')]
    public ?int $outstandingInvoices;

    /**
     * @param array{
     *   status: value-of<SubscriptionStateStatus>,
     *   paidInvoices: int,
     *   nextDueDate?: ?DateTime,
     *   outstandingInvoices?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->status = $values['status'];
        $this->nextDueDate = $values['nextDueDate'] ?? null;
        $this->paidInvoices = $values['paidInvoices'];
        $this->outstandingInvoices = $values['outstandingInvoices'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
