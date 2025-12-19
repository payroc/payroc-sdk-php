<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaginatedList;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class PaginatedMerchants extends JsonSerializableType
{
    use PaginatedList;

    /**
     * @var ?array<MerchantPlatform> $data Array of merchantPlatform objects.
     */
    #[JsonProperty('data'), ArrayType([MerchantPlatform::class])]
    public ?array $data;

    /**
     * @param array{
     *   limit?: ?float,
     *   count?: ?float,
     *   hasMore?: ?bool,
     *   links?: ?array<Link>,
     *   data?: ?array<MerchantPlatform>,
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
