<?php

namespace Payroc\Traits;

use Payroc\Types\RetrievedTax;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * @property ?array<RetrievedTax> $taxes
 */
trait Breakdown
{
    use BreakdownBase;

    /**
     * @var ?array<RetrievedTax> $taxes List of taxes.
     */
    #[JsonProperty('taxes'), ArrayType([RetrievedTax::class])]
    public ?array $taxes;
}
