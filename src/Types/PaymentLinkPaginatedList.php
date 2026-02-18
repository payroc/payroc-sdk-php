<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaginatedList;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class PaymentLinkPaginatedList extends JsonSerializableType
{
    use PaginatedList;

    /**
     * Array of polymorphic objects that contains payment link information.
     *
     * The value of the type parameter determines which variant you should use:
     * -	'multiUse' - Create a link that the merchant can use to take multiple payments.
     * -	'singleUse' - Create a link that the merchant can use for only one payment.
     *
     * @var ?array<PaymentLinkPaginatedListDataItem> $data
     */
    #[JsonProperty('data'), ArrayType([PaymentLinkPaginatedListDataItem::class])]
    public ?array $data;

    /**
     * @param array{
     *   limit?: ?int,
     *   count?: ?int,
     *   hasMore?: ?bool,
     *   links?: ?array<Link>,
     *   data?: ?array<PaymentLinkPaginatedListDataItem>,
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
