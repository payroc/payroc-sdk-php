<?php

namespace Payroc\Notifications\EventSubscriptions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\EventSubscription;

class UpdateEventSubscriptionsRequest extends JsonSerializableType
{
    /**
     * @var EventSubscription $body
     */
    public EventSubscription $body;

    /**
     * @param array{
     *   body: EventSubscription,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
