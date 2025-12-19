<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the address.
 */
class RetrievedAddress extends JsonSerializableType
{
    /**
     * @var ?string $address1 Address line 1.
     */
    #[JsonProperty('address1')]
    public ?string $address1;

    /**
     * @var ?string $address2 Address line 2.
     */
    #[JsonProperty('address2')]
    public ?string $address2;

    /**
     * @var ?string $address3 Address line 3.
     */
    #[JsonProperty('address3')]
    public ?string $address3;

    /**
     * @var ?string $city City.
     */
    #[JsonProperty('city')]
    public ?string $city;

    /**
     * @var ?string $state Name of the state or state abbreviation.
     */
    #[JsonProperty('state')]
    public ?string $state;

    /**
     * @var ?string $country Two-digit country code for the country that the business operates in. The format follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @var ?string $postalCode Zip code or postal code.
     */
    #[JsonProperty('postalCode')]
    public ?string $postalCode;

    /**
     * @param array{
     *   address1?: ?string,
     *   address2?: ?string,
     *   address3?: ?string,
     *   city?: ?string,
     *   state?: ?string,
     *   country?: ?string,
     *   postalCode?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->address1 = $values['address1'] ?? null;
        $this->address2 = $values['address2'] ?? null;
        $this->address3 = $values['address3'] ?? null;
        $this->city = $values['city'] ?? null;
        $this->state = $values['state'] ?? null;
        $this->country = $values['country'] ?? null;
        $this->postalCode = $values['postalCode'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
