<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\CommonFunding;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the funding schedule of the processing account.
 */
class CreateFunding extends JsonSerializableType
{
    use CommonFunding;

    /**
     * @var ?array<FundingAccount> $fundingAccounts Array of fundingAccounts objects.
     */
    #[JsonProperty('fundingAccounts'), ArrayType([FundingAccount::class])]
    public ?array $fundingAccounts;

    /**
     * @param array{
     *   status?: ?value-of<CommonFundingStatus>,
     *   fundingSchedule?: ?value-of<CommonFundingFundingSchedule>,
     *   acceleratedFundingFee?: ?int,
     *   dailyDiscount?: ?bool,
     *   fundingAccounts?: ?array<FundingAccount>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->fundingSchedule = $values['fundingSchedule'] ?? null;
        $this->acceleratedFundingFee = $values['acceleratedFundingFee'] ?? null;
        $this->dailyDiscount = $values['dailyDiscount'] ?? null;
        $this->fundingAccounts = $values['fundingAccounts'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
