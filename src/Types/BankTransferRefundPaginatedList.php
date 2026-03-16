<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaginatedList;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class BankTransferRefundPaginatedList extends JsonSerializableType
{
    use PaginatedList;

    /**
     * @var array<BankTransferRefund> $data Array of refund transactions.
     */
    #[JsonProperty('data'), ArrayType([BankTransferRefund::class])]
    public array $data;

    /**
     * @param array{
     *   data: array<BankTransferRefund>,
     *   limit?: ?int,
     *   count?: ?int,
     *   hasMore?: ?bool,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->count = $values['count'] ?? null;
        $this->hasMore = $values['hasMore'] ?? null;
        $this->links = $values['links'] ?? null;
        $this->data = $values['data'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
