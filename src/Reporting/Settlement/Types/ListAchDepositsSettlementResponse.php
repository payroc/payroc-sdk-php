<?php

namespace Payroc\Reporting\Settlement\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaginatedList;
use Payroc\Types\AchDeposit;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;
use Payroc\Types\Link;

class ListAchDepositsSettlementResponse extends JsonSerializableType
{
    use PaginatedList;

    /**
     * @var array<AchDeposit> $data Array of ACH deposit objects.
     */
    #[JsonProperty('data'), ArrayType([AchDeposit::class])]
    public array $data;

    /**
     * @param array{
     *   data: array<AchDeposit>,
     *   limit?: ?float,
     *   count?: ?float,
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
