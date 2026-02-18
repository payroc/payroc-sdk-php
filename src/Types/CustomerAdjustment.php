<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the adjustment to the transaction. Send this object if the merchant is adjusting the customer’s contact details.
 */
class CustomerAdjustment extends JsonSerializableType
{
    /**
     * @var ?Shipping $shippingAddress
     */
    #[JsonProperty('shippingAddress')]
    public ?Shipping $shippingAddress;

    /**
     * Array of polymorphic objects, which contain contact information.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`email` - Email address
     * -	`phone` - Phone number
     * -	`mobile` - Mobile number
     * -	`fax` - Fax number
     *
     * @var ?array<ContactMethod> $contactMethods
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public ?array $contactMethods;

    /**
     * @param array{
     *   shippingAddress?: ?Shipping,
     *   contactMethods?: ?array<ContactMethod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->shippingAddress = $values['shippingAddress'] ?? null;
        $this->contactMethods = $values['contactMethods'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
