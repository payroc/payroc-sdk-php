<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class CommonFunding extends JsonSerializableType
{
    /**
     * @var ?value-of<CommonFundingStatus> $status Indicates if the processing account can receive funds.
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * Indicates when funds are sent to the funding account.
     *
     * If you send a value of `sameDay` or `nextDay`, provide a value for acceleratedFundingFee.
     *
     * **Note:** If you send a value of `sameday`, funding includes all transactions the merchant ran before the ACH cut-off time.
     *
     * @var ?value-of<CommonFundingFundingSchedule> $fundingSchedule
     */
    #[JsonProperty('fundingSchedule')]
    public ?string $fundingSchedule;

    /**
     * Monthly fee in cents for accelerated funding. The value is in the currency's lowest denomination, for example, cents.
     *
     * We apply this fee if the value for fundingSchedule is `sameday` or `nextday`.
     *
     * @var ?int $acceleratedFundingFee
     */
    #[JsonProperty('acceleratedFundingFee')]
    public ?int $acceleratedFundingFee;

    /**
     * @var ?bool $dailyDiscount Indicates if we collect fees from the merchant's account each day.
     */
    #[JsonProperty('dailyDiscount')]
    public ?bool $dailyDiscount;

    /**
     * @param array{
     *   status?: ?value-of<CommonFundingStatus>,
     *   fundingSchedule?: ?value-of<CommonFundingFundingSchedule>,
     *   acceleratedFundingFee?: ?int,
     *   dailyDiscount?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->status = $values['status'] ?? null;
        $this->fundingSchedule = $values['fundingSchedule'] ?? null;
        $this->acceleratedFundingFee = $values['acceleratedFundingFee'] ?? null;
        $this->dailyDiscount = $values['dailyDiscount'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
