<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\AddressType;
use Payroc\Traits\Address;

class LegalAddress extends JsonSerializableType
{
    use AddressType;
    use Address;


    /**
     * @param array{
     *   type: value-of<AddressTypeType>,
     *   address1: string,
     *   city: string,
     *   state: string,
     *   country: string,
     *   postalCode: string,
     *   address2?: ?string,
     *   address3?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->address1 = $values['address1'];
        $this->address2 = $values['address2'] ?? null;
        $this->address3 = $values['address3'] ?? null;
        $this->city = $values['city'];
        $this->state = $values['state'];
        $this->country = $values['country'];
        $this->postalCode = $values['postalCode'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
