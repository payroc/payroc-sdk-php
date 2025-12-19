<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaginatedList;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class BankTransferPaymentPaginatedList extends JsonSerializableType
{
    use PaginatedList;

    /**
     * @var ?array<BankTransferPayment> $data Array of payments.
     */
    #[JsonProperty('data'), ArrayType([BankTransferPayment::class])]
    public ?array $data;

    /**
     * @param array{
     *   limit?: ?float,
     *   count?: ?float,
     *   hasMore?: ?bool,
     *   links?: ?array<Link>,
     *   data?: ?array<BankTransferPayment>,
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
