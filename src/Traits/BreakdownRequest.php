<?php

namespace Payroc\Traits;

use Payroc\Types\Tax;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * @property ?array<Tax> $taxes
 */
trait BreakdownRequest
{
    use BreakdownBase;

    /**
     * @var ?array<Tax> $taxes List of taxes.
     */
    #[JsonProperty('taxes'), ArrayType([Tax::class])]
    public ?array $taxes;
}
