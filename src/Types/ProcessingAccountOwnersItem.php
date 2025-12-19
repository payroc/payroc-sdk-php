<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class ProcessingAccountOwnersItem extends JsonSerializableType
{
    /**
     * @var ?int $ownerId Unique identifier of the owner.
     */
    #[JsonProperty('ownerId')]
    public ?int $ownerId;

    /**
     * @var ?string $firstName Owner's first name.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Owner's last name.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?ProcessingAccountOwnersItemLink $link HATEOAS links to the owners of the processing account.
     */
    #[JsonProperty('link')]
    public ?ProcessingAccountOwnersItemLink $link;

    /**
     * @param array{
     *   ownerId?: ?int,
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   link?: ?ProcessingAccountOwnersItemLink,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ownerId = $values['ownerId'] ?? null;
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
