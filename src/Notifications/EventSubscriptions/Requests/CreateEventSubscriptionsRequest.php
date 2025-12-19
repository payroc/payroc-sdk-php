<?php

namespace Payroc\Notifications\EventSubscriptions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\EventSubscription;

class CreateEventSubscriptionsRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var EventSubscription $body
     */
    public EventSubscription $body;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   body: EventSubscription,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->body = $values['body'];
    }
}
