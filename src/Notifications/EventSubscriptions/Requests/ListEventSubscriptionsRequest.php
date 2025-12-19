<?php

namespace Payroc\Notifications\EventSubscriptions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Notifications\EventSubscriptions\Types\ListEventSubscriptionsRequestStatus;

class ListEventSubscriptionsRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<ListEventSubscriptionsRequestStatus> $status Filter event subscriptions by subscription status.
     */
    public ?string $status;

    /**
     * @var ?string $event Filter event subscriptions by an event type. For a list of event types, go to [Events List](https://docs.payroc.com/knowledge/events/events-list).
     */
    public ?string $event;

    /**
     * @param array{
     *   status?: ?value-of<ListEventSubscriptionsRequestStatus>,
     *   event?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->event = $values['event'] ?? null;
    }
}
