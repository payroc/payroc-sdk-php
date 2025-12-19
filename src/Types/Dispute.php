<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the dispute.
 */
class Dispute extends JsonSerializableType
{
    /**
     * @var ?int $disputeId Unique identifier that we assigned to the dispute.
     */
    #[JsonProperty('disputeId')]
    public ?int $disputeId;

    /**
     * @var ?value-of<DisputeDisputeType> $disputeType Type of dispute.
     */
    #[JsonProperty('disputeType')]
    public ?string $disputeType;

    /**
     * @var ?DisputeCurrentStatus $currentStatus Object that contains information about the current status of the dispute.
     */
    #[JsonProperty('currentStatus')]
    public ?DisputeCurrentStatus $currentStatus;

    /**
     * @var ?DateTime $createdDate Date that we received the dispute. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date that the dispute was last changed. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $lastModifiedDate;

    /**
     * @var ?DateTime $receivedDate Date that the acquiring bank received the dispute. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('receivedDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $receivedDate;

    /**
     * @var ?string $description Description of the dispute.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?string $referenceNumber Reference number from the acquiring bank.
     */
    #[JsonProperty('referenceNumber')]
    public ?string $referenceNumber;

    /**
     * @var ?int $disputeAmount Dispute amount. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('disputeAmount')]
    public ?int $disputeAmount;

    /**
     * @var ?int $feeAmount Value of the fees for the dispute. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('feeAmount')]
    public ?int $feeAmount;

    /**
     * @var ?bool $firstDispute Indicates if this is the first dispute for the transaction.
     */
    #[JsonProperty('firstDispute')]
    public ?bool $firstDispute;

    /**
     * @var ?string $authorizationCode Authorization code of the transaction that the dispute is linked to.
     */
    #[JsonProperty('authorizationCode')]
    public ?string $authorizationCode;

    /**
     * @var ?string $currency Currency of the transaction that the dispute is linked to. The value for the currency follows the [ISO 4217](https://www.iso.org/iso-4217-currency-codes.html) standard.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?CardSummary $card
     */
    #[JsonProperty('card')]
    public ?CardSummary $card;

    /**
     * @var ?MerchantSummary $merchant
     */
    #[JsonProperty('merchant')]
    public ?MerchantSummary $merchant;

    /**
     * @var ?TransactionSummary $transaction
     */
    #[JsonProperty('transaction')]
    public ?TransactionSummary $transaction;

    /**
     * @param array{
     *   disputeId?: ?int,
     *   disputeType?: ?value-of<DisputeDisputeType>,
     *   currentStatus?: ?DisputeCurrentStatus,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   receivedDate?: ?DateTime,
     *   description?: ?string,
     *   referenceNumber?: ?string,
     *   disputeAmount?: ?int,
     *   feeAmount?: ?int,
     *   firstDispute?: ?bool,
     *   authorizationCode?: ?string,
     *   currency?: ?string,
     *   card?: ?CardSummary,
     *   merchant?: ?MerchantSummary,
     *   transaction?: ?TransactionSummary,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->disputeId = $values['disputeId'] ?? null;
        $this->disputeType = $values['disputeType'] ?? null;
        $this->currentStatus = $values['currentStatus'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->receivedDate = $values['receivedDate'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->referenceNumber = $values['referenceNumber'] ?? null;
        $this->disputeAmount = $values['disputeAmount'] ?? null;
        $this->feeAmount = $values['feeAmount'] ?? null;
        $this->firstDispute = $values['firstDispute'] ?? null;
        $this->authorizationCode = $values['authorizationCode'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->card = $values['card'] ?? null;
        $this->merchant = $values['merchant'] ?? null;
        $this->transaction = $values['transaction'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
