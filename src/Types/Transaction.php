<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the transaction.
 */
class Transaction extends JsonSerializableType
{
    /**
     * @var ?int $transactionId Unique identifier that we assigned to the transaction.
     */
    #[JsonProperty('transactionId')]
    public ?int $transactionId;

    /**
     * Indicates the type of transaction. The value is one of the following:
     *
     * - `capture` - Transaction is a sale.
     * - `return` - Transaction is a refund.
     *
     * @var ?value-of<TransactionType> $type
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?DateTime $date Date of the transaction. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public ?DateTime $date;

    /**
     * @var ?int $amount Transaction amount. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?value-of<TransactionEntryMethod> $entryMethod Indicates how the merchant received the payment details.
     */
    #[JsonProperty('entryMethod')]
    public ?string $entryMethod;

    /**
     * @var ?DateTime $createdDate Date that we received the transaction.  The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date that the transaction was last changed.  The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $lastModifiedDate;

    /**
     * Indicates the status of the transaction. The value is one of the following:
     *
     * -	`fullSuspense` – Merchant ran the transaction while their account was in full suspense.
     * -	`heldAudited` – We have moved a transaction from fullSuspense and placed it on hold.
     * -	`heldReleasedAudited` – We audited and released the transaction that we had previously held.
     * -	`holdForSettlement30Days` - We are holding the transaction for a maximum of 30 days.
     * -	`holdForSettlementDuplicate` - We held the transaction because the transaction may be a duplicate.
     * -	`holdLongTerm` - We are holding the transaction for an extended period.
     * -	`paid` – We have paid the transaction funds to the merchant.
     * -	`paidByThirdParty` - A third party has paid the transaction funds to the merchant.
     * -	`partialRelease` – We partially released the transaction funds.
     * -	`pull` - We pulled the transaction, and the merchant does not receive funds for the transaction.
     * -	`release` - We released the transaction that we previously held.
     * -	`new` – We have prepared the funds from the transaction to send to the merchant.
     * -	`held` – We held the transaction.
     * -	`unknown` – No transaction status available.
     *
     * @var ?value-of<TransactionStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?int $cashbackAmount Cashback amount. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('cashbackAmount')]
    public ?int $cashbackAmount;

    /**
     * @var ?TransactionInterchange $interchange Object that contains information about the interchange fees for the transaction.
     */
    #[JsonProperty('interchange')]
    public ?TransactionInterchange $interchange;

    /**
     * @var ?string $currency Currency of the transaction. The value for the currency follows the [ISO 4217](https://www.iso.org/iso-4217-currency-codes.html) standard.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?MerchantSummary $merchant
     */
    #[JsonProperty('merchant')]
    public ?MerchantSummary $merchant;

    /**
     * @var ?SettledSummary $settled
     */
    #[JsonProperty('settled')]
    public ?SettledSummary $settled;

    /**
     * @var ?BatchSummary $batch
     */
    #[JsonProperty('batch')]
    public ?BatchSummary $batch;

    /**
     * @var ?CardSummary $card
     */
    #[JsonProperty('card')]
    public ?CardSummary $card;

    /**
     * @var ?AuthorizationSummary $authorization
     */
    #[JsonProperty('authorization')]
    public ?AuthorizationSummary $authorization;

    /**
     * @param array{
     *   transactionId?: ?int,
     *   type?: ?value-of<TransactionType>,
     *   date?: ?DateTime,
     *   amount?: ?int,
     *   entryMethod?: ?value-of<TransactionEntryMethod>,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   status?: ?value-of<TransactionStatus>,
     *   cashbackAmount?: ?int,
     *   interchange?: ?TransactionInterchange,
     *   currency?: ?string,
     *   merchant?: ?MerchantSummary,
     *   settled?: ?SettledSummary,
     *   batch?: ?BatchSummary,
     *   card?: ?CardSummary,
     *   authorization?: ?AuthorizationSummary,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->transactionId = $values['transactionId'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->entryMethod = $values['entryMethod'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->cashbackAmount = $values['cashbackAmount'] ?? null;
        $this->interchange = $values['interchange'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->merchant = $values['merchant'] ?? null;
        $this->settled = $values['settled'] ?? null;
        $this->batch = $values['batch'] ?? null;
        $this->card = $values['card'] ?? null;
        $this->authorization = $values['authorization'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
