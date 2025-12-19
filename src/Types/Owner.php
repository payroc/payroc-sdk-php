<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class Owner extends JsonSerializableType
{
    /**
     * @var ?int $ownerId Unique identifier that we assigned to the owner.
     */
    #[JsonProperty('ownerId')]
    public ?int $ownerId;

    /**
     * @var string $firstName Owner's first name.
     */
    #[JsonProperty('firstName')]
    public string $firstName;

    /**
     * @var ?string $middleName Owner's middle name.
     */
    #[JsonProperty('middleName')]
    public ?string $middleName;

    /**
     * @var string $lastName Owner's last name.
     */
    #[JsonProperty('lastName')]
    public string $lastName;

    /**
     * @var DateTime $dateOfBirth Owner's date of birth. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('dateOfBirth'), Date(Date::TYPE_DATE)]
    public DateTime $dateOfBirth;

    /**
     * @var Address $address
     */
    #[JsonProperty('address')]
    public Address $address;

    /**
     * @var array<Identifier> $identifiers Array of IDs.
     */
    #[JsonProperty('identifiers'), ArrayType([Identifier::class])]
    public array $identifiers;

    /**
     * Array of contactMethod objects.
     * **Note:** If you are adding information about an owner, you must provide at least an email address. If you are adding information about a contact, you must provide at least a contact number.
     *
     * @var array<ContactMethod> $contactMethods
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @var OwnerRelationship $relationship Object that contains information about the owner's relationship to the business.
     */
    #[JsonProperty('relationship')]
    public OwnerRelationship $relationship;

    /**
     * @param array{
     *   firstName: string,
     *   lastName: string,
     *   dateOfBirth: DateTime,
     *   address: Address,
     *   identifiers: array<Identifier>,
     *   contactMethods: array<ContactMethod>,
     *   relationship: OwnerRelationship,
     *   ownerId?: ?int,
     *   middleName?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ownerId = $values['ownerId'] ?? null;
        $this->firstName = $values['firstName'];
        $this->middleName = $values['middleName'] ?? null;
        $this->lastName = $values['lastName'];
        $this->dateOfBirth = $values['dateOfBirth'];
        $this->address = $values['address'];
        $this->identifiers = $values['identifiers'];
        $this->contactMethods = $values['contactMethods'];
        $this->relationship = $values['relationship'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
