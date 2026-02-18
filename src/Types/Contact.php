<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class Contact extends JsonSerializableType
{
    /**
     * @var ?int $contactId Unique identifier of the contact.
     */
    #[JsonProperty('contactId')]
    public ?int $contactId;

    /**
     * @var value-of<ContactType> $type Type of contact.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $firstName Contact's first name.
     */
    #[JsonProperty('firstName')]
    public string $firstName;

    /**
     * @var ?string $middleName Contact's middle name.
     */
    #[JsonProperty('middleName')]
    public ?string $middleName;

    /**
     * @var string $lastName Contact's last name.
     */
    #[JsonProperty('lastName')]
    public string $lastName;

    /**
     * @var array<Identifier> $identifiers Array of identifier objects.
     */
    #[JsonProperty('identifiers'), ArrayType([Identifier::class])]
    public array $identifiers;

    /**
     * Array of polymorphic objects, which contain contact information.
     *
     * **Note:** If you are adding information about an owner, you must provide at least an email address. If you are adding information about a contact, you must provide at least a contact number.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`email` - Email address
     * -	`phone` - Phone number
     * -	`mobile` - Mobile number
     * -	`fax` - Fax number
     *
     * @var array<ContactMethod> $contactMethods
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @param array{
     *   type: value-of<ContactType>,
     *   firstName: string,
     *   lastName: string,
     *   identifiers: array<Identifier>,
     *   contactMethods: array<ContactMethod>,
     *   contactId?: ?int,
     *   middleName?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->contactId = $values['contactId'] ?? null;
        $this->type = $values['type'];
        $this->firstName = $values['firstName'];
        $this->middleName = $values['middleName'] ?? null;
        $this->lastName = $values['lastName'];
        $this->identifiers = $values['identifiers'];
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
