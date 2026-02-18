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
     * Array of polymorphic tax objects, which contain information about a tax.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`amount` - Tax is a fixed amount.
     * -	`rate` - Tax is a percentage.
     *
     * @var ?array<Tax> $taxes
     */
    #[JsonProperty('taxes'), ArrayType([Tax::class])]
    public ?array $taxes;
}
