<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use DateTime;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the ACH deposit fee.
 */
class AchDepositFee extends JsonSerializableType
{
    /**
     * @var ?DateTime $associationDate Date that we sent the transaction to the cards brands for clearing. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('associationDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $associationDate;

    /**
     * @var ?DateTime $adjustmentDate Date of the adjustment. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('adjustmentDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $adjustmentDate;

    /**
     * @var ?string $description Description of the ACH deposit fee.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?int $amount Total value of ACH deposit fee.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?MerchantSummary $merchant
     */
    #[JsonProperty('merchant')]
    public ?MerchantSummary $merchant;

    /**
     * @var ?AchDepositSummary $achDeposit
     */
    #[JsonProperty('achDeposit')]
    public ?AchDepositSummary $achDeposit;

    /**
     * @param array{
     *   associationDate?: ?DateTime,
     *   adjustmentDate?: ?DateTime,
     *   description?: ?string,
     *   amount?: ?int,
     *   merchant?: ?MerchantSummary,
     *   achDeposit?: ?AchDepositSummary,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->associationDate = $values['associationDate'] ?? null;
        $this->adjustmentDate = $values['adjustmentDate'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->merchant = $values['merchant'] ?? null;
        $this->achDeposit = $values['achDeposit'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
