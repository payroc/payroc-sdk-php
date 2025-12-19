<?php

namespace Payroc\Traits;

use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the address.
 *
 * @property string $address1
 * @property ?string $address2
 * @property ?string $address3
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $postalCode
 */
trait Address
{
    /**
     * @var string $address1 Address line 1.
     */
    #[JsonProperty('address1')]
    public string $address1;

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
     * @var string $city City.
     */
    #[JsonProperty('city')]
    public string $city;

    /**
     * @var string $state Name of the state or state abbreviation.
     */
    #[JsonProperty('state')]
    public string $state;

    /**
     * @var string $country Two-digit country code for the country that the business operates in. The format follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public string $country;

    /**
     * @var string $postalCode Zip code or postal code.
     */
    #[JsonProperty('postalCode')]
    public string $postalCode;
}
