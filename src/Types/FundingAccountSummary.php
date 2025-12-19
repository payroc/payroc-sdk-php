<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class FundingAccountSummary extends JsonSerializableType
{
    /**
     * @var ?int $fundingAccountId Unique identifier that we assigned to the funding account.
     */
    #[JsonProperty('fundingAccountId')]
    public ?int $fundingAccountId;

    /**
     * @var ?value-of<FundingAccountSummaryStatus> $status Status of the funding account.
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?Link $link Object that contains HATEOAS links for the funding accounts that are linked to the processing account.
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   fundingAccountId?: ?int,
     *   status?: ?value-of<FundingAccountSummaryStatus>,
     *   link?: ?Link,
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
