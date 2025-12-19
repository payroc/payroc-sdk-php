<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class ProcessingAccountContactsItem extends JsonSerializableType
{
    /**
     * @var ?int $contactId Unique identifier of the contact.
     */
    #[JsonProperty('contactId')]
    public ?int $contactId;

    /**
     * @var ?string $firstName Contact's first name.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Contact's last name.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?ProcessingAccountContactsItemLink $link Object that contains HATEOAS links for the contact.
     */
    #[JsonProperty('link')]
    public ?ProcessingAccountContactsItemLink $link;

    /**
     * @param array{
     *   contactId?: ?int,
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   link?: ?ProcessingAccountContactsItemLink,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->contactId = $values['contactId'] ?? null;
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
