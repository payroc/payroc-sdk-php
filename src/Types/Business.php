<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the business.
 */
class Business extends JsonSerializableType
{
    /**
     * @var string $name Legal name of the business.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var string $taxId Tax ID of the business.
     */
    #[JsonProperty('taxId')]
    public string $taxId;

    /**
     * @var value-of<BusinessOrganizationType> $organizationType Type of organization.
     */
    #[JsonProperty('organizationType')]
    public string $organizationType;

    /**
     * @var ?value-of<BusinessCountryOfOperation> $countryOfOperation Two-digit code for the country that the business operates in. The format follows the [ISO-3166](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('countryOfOperation')]
    public ?string $countryOfOperation;

    /**
     * @var array<LegalAddress> $addresses Object that contains the addresses for the business.
     */
    #[JsonProperty('addresses'), ArrayType([LegalAddress::class])]
    public array $addresses;

    /**
     * @var array<ContactMethod> $contactMethods Array of contactMethod objects. One contact method must be an email address.
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @param array{
     *   name: string,
     *   taxId: string,
     *   organizationType: value-of<BusinessOrganizationType>,
     *   addresses: array<LegalAddress>,
     *   contactMethods: array<ContactMethod>,
     *   countryOfOperation?: ?value-of<BusinessCountryOfOperation>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
        $this->taxId = $values['taxId'];
        $this->organizationType = $values['organizationType'];
        $this->countryOfOperation = $values['countryOfOperation'] ?? null;
        $this->addresses = $values['addresses'];
        $this->contactMethods = $values['contactMethods'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
