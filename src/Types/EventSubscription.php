<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class EventSubscription extends JsonSerializableType
{
    /**
     * @var ?int $id Unique identifier that we assigned to the event subscription.
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * Indicates if we should notify you when the event occurs. The value is one of the following:
     * - `true` - We notify you when the event occurs.
     * - `false` - We don't notify you when the event occurs.
     *
     * @var bool $enabled
     */
    #[JsonProperty('enabled')]
    public bool $enabled;

    /**
     * Status of the subscription. We return one of the following values:
     * - `registered` - You have set up the subscription, and we will notify you when an event occurs.
     * - `suspended` - We have deactivated the event subscription, and we won't notify you when an event occurs.
     * - `failed` - We couldn't contact your URI endpoint. We email the supportEmailAddress.
     *
     * @var ?value-of<EventSubscriptionStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var array<string> $eventTypes Array of events that you want to subscribe to. For a list of events, go to [Events List](https://docs.payroc.com/knowledge/events/events-list).
     */
    #[JsonProperty('eventTypes'), ArrayType(['string'])]
    public array $eventTypes;

    /**
     * @var array<Notification> $notifications Array of notifications objects. Each object contains information about how we contact you when an event occurs.
     */
    #[JsonProperty('notifications'), ArrayType([Notification::class])]
    public array $notifications;

    /**
     * @var ?array<string, mixed> $metadata Object that you can send to include custom data in the request. For more information about how to use metadata, go to [Metadata](https://docs.payroc.com/api/metadata).
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'mixed'])]
    public ?array $metadata;

    /**
     * @param array{
     *   enabled: bool,
     *   eventTypes: array<string>,
     *   notifications: array<Notification>,
     *   id?: ?int,
     *   status?: ?value-of<EventSubscriptionStatus>,
     *   metadata?: ?array<string, mixed>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'] ?? null;
        $this->enabled = $values['enabled'];
        $this->status = $values['status'] ?? null;
        $this->eventTypes = $values['eventTypes'];
        $this->notifications = $values['notifications'];
        $this->metadata = $values['metadata'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
