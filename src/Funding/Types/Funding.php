<?php

namespace Payroc\Funding\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\CommonFunding;
use Payroc\Types\FundingAccountSummary;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;
use Payroc\Types\CommonFundingStatus;
use Payroc\Types\CommonFundingFundingSchedule;

/**
 * Object that contains funding information for the processing account, including funding schedules, funding fees, and details of funding accounts.
 */
class Funding extends JsonSerializableType
{
    use CommonFunding;

    /**
     * @var ?array<FundingAccountSummary> $fundingAccounts Object that contains funding accounts associated with the processing account.
     */
    #[JsonProperty('fundingAccounts'), ArrayType([FundingAccountSummary::class])]
    public ?array $fundingAccounts;

    /**
     * @param array{
     *   status?: ?value-of<CommonFundingStatus>,
     *   fundingSchedule?: ?value-of<CommonFundingFundingSchedule>,
     *   acceleratedFundingFee?: ?int,
     *   dailyDiscount?: ?bool,
     *   fundingAccounts?: ?array<FundingAccountSummary>,
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
