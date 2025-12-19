<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the ACH deposit.
 */
class AchDeposit extends JsonSerializableType
{
    /**
     * @var ?int $achDepositId Unique identifier that we assigned to the ACH deposit.
     */
    #[JsonProperty('achDepositId')]
    public ?int $achDepositId;

    /**
     * @var ?DateTime $associationDate Date that we sent the transactions to the card brands for clearing. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('associationDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $associationDate;

    /**
     * @var ?DateTime $achDate Date that we sent the ACH deposit. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('achDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $achDate;

    /**
     * @var ?DateTime $paymentDate Date that the merchant received the ACH deposit. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('paymentDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $paymentDate;

    /**
     * @var ?int $transactions Number of transactions in the ACH deposit.
     */
    #[JsonProperty('transactions')]
    public ?int $transactions;

    /**
     * @var ?int $sales Amount of sales in the ACH deposit. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('sales')]
    public ?int $sales;

    /**
     * @var ?int $returns Amount of returns in the ACH deposit. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('returns')]
    public ?int $returns;

    /**
     * @var ?int $dailyFees Amount of fees that were applied to the transactions in the ACH deposit. We return the value in the currency's lowest denomination, for example cents.
     */
    #[JsonProperty('dailyFees')]
    public ?int $dailyFees;

    /**
     * @var ?int $heldSales Amount of funds that we held if the merchant was in full suspense. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('heldSales')]
    public ?int $heldSales;

    /**
     * @var ?int $achAdjustment Amount of adjustments that we made to the ACH deposit. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('achAdjustment')]
    public ?int $achAdjustment;

    /**
     * @var ?int $holdback Amount of funds that we held as reserve from the ACH deposit. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('holdback')]
    public ?int $holdback;

    /**
     * @var ?int $reserveRelease Amount of funds that we released from holdback. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('reserveRelease')]
    public ?int $reserveRelease;

    /**
     * @var ?int $netAmount Total amount that we paid the merchant after fees and adjustments. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('netAmount')]
    public ?int $netAmount;

    /**
     * @var ?MerchantSummary $merchant
     */
    #[JsonProperty('merchant')]
    public ?MerchantSummary $merchant;

    /**
     * @var ?array<Link> $links
     */
    #[JsonProperty('links'), ArrayType([Link::class])]
    public ?array $links;

    /**
     * @param array{
     *   achDepositId?: ?int,
     *   associationDate?: ?DateTime,
     *   achDate?: ?DateTime,
     *   paymentDate?: ?DateTime,
     *   transactions?: ?int,
     *   sales?: ?int,
     *   returns?: ?int,
     *   dailyFees?: ?int,
     *   heldSales?: ?int,
     *   achAdjustment?: ?int,
     *   holdback?: ?int,
     *   reserveRelease?: ?int,
     *   netAmount?: ?int,
     *   merchant?: ?MerchantSummary,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->achDepositId = $values['achDepositId'] ?? null;
        $this->associationDate = $values['associationDate'] ?? null;
        $this->achDate = $values['achDate'] ?? null;
        $this->paymentDate = $values['paymentDate'] ?? null;
        $this->transactions = $values['transactions'] ?? null;
        $this->sales = $values['sales'] ?? null;
        $this->returns = $values['returns'] ?? null;
        $this->dailyFees = $values['dailyFees'] ?? null;
        $this->heldSales = $values['heldSales'] ?? null;
        $this->achAdjustment = $values['achAdjustment'] ?? null;
        $this->holdback = $values['holdback'] ?? null;
        $this->reserveRelease = $values['reserveRelease'] ?? null;
        $this->netAmount = $values['netAmount'] ?? null;
        $this->merchant = $values['merchant'] ?? null;
        $this->links = $values['links'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
