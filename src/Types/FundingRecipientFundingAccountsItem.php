<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FundingRecipientFundingAccountsItem extends JsonSerializableType
{
    /**
     * @var ?int $fundingAccountId Unique identifier of the funding account.
     */
    #[JsonProperty('fundingAccountId')]
    public ?int $fundingAccountId;

    /**
     * @var ?value-of<FundingRecipientFundingAccountsItemStatus> $status Status of the funding account.
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?FundingRecipientFundingAccountsItemLink $link Object that contains HATEOAS links for the resource.
     */
    #[JsonProperty('link')]
    public ?FundingRecipientFundingAccountsItemLink $link;

    /**
     * @param array{
     *   fundingAccountId?: ?int,
     *   status?: ?value-of<FundingRecipientFundingAccountsItemStatus>,
     *   link?: ?FundingRecipientFundingAccountsItemLink,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->fundingAccountId = $values['fundingAccountId'] ?? null;
        $this->status = $values['status'] ?? null;
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
