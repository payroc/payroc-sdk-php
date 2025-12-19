<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class Batch extends JsonSerializableType
{
    /**
     * @var ?int $batchId Unique identifier that we assigned to the batch.
     */
    #[JsonProperty('batchId')]
    public ?int $batchId;

    /**
     * @var ?DateTime $date Date that the merchant submitted the batch. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public ?DateTime $date;

    /**
     * @var ?DateTime $createdDate Date that we created a record for the batch. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date that the batch was last changed. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $lastModifiedDate;

    /**
     * @var ?int $saleAmount Total value of sales in the batch. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('saleAmount')]
    public ?int $saleAmount;

    /**
     * @var ?int $heldAmount Total value of authorizations in the batch. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('heldAmount')]
    public ?int $heldAmount;

    /**
     * @var ?int $returnAmount Total value of returns in the batch. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('returnAmount')]
    public ?int $returnAmount;

    /**
     * @var ?int $transactionCount Total number of transactions in the batch.
     */
    #[JsonProperty('transactionCount')]
    public ?int $transactionCount;

    /**
     * @var ?string $currency Currency of the transactions in the batch. The value for the currency follows the [ISO 4217](https://www.iso.org/iso-4217-currency-codes.html) standard.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

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
     *   batchId?: ?int,
     *   date?: ?DateTime,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   saleAmount?: ?int,
     *   heldAmount?: ?int,
     *   returnAmount?: ?int,
     *   transactionCount?: ?int,
     *   currency?: ?string,
     *   merchant?: ?MerchantSummary,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->batchId = $values['batchId'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->saleAmount = $values['saleAmount'] ?? null;
        $this->heldAmount = $values['heldAmount'] ?? null;
        $this->returnAmount = $values['returnAmount'] ?? null;
        $this->transactionCount = $values['transactionCount'] ?? null;
        $this->currency = $values['currency'] ?? null;
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
