<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FundingRecipientOwnersItem extends JsonSerializableType
{
    /**
     * @var ?int $ownerId Unique identifier of the owner.
     */
    #[JsonProperty('ownerId')]
    public ?int $ownerId;

    /**
     * @var ?FundingRecipientOwnersItemLink $link Object that contains HATEOAS links for the resource.
     */
    #[JsonProperty('link')]
    public ?FundingRecipientOwnersItemLink $link;

    /**
     * @param array{
     *   ownerId?: ?int,
     *   link?: ?FundingRecipientOwnersItemLink,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ownerId = $values['ownerId'] ?? null;
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
