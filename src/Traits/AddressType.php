<?php

namespace Payroc\Traits;

use Payroc\Types\AddressTypeType;
use Payroc\Core\Json\JsonProperty;

/**
 * Type of address.
 *
 * @property value-of<AddressTypeType> $type
 */
trait AddressType
{
    /**
     * @var value-of<AddressTypeType> $type Type of address.
     */
    #[JsonProperty('type')]
    public string $type;
}
