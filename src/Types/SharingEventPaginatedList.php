<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaginatedList;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class SharingEventPaginatedList extends JsonSerializableType
{
    use PaginatedList;

    /**
     * @var ?array<PaymentLinkEmailShareEvent> $data Array of sharing events for the payment link.
     */
    #[JsonProperty('data'), ArrayType([PaymentLinkEmailShareEvent::class])]
    public ?array $data;

    /**
     * @param array{
     *   limit?: ?float,
     *   count?: ?float,
     *   hasMore?: ?bool,
     *   links?: ?array<Link>,
     *   data?: ?array<PaymentLinkEmailShareEvent>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->count = $values['count'] ?? null;
        $this->hasMore = $values['hasMore'] ?? null;
        $this->links = $values['links'] ?? null;
        $this->data = $values['data'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
