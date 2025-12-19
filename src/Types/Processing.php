<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about how we process transactions for the account.
 */
class Processing extends JsonSerializableType
{
    /**
     * @var ?string $merchantId Unique identifier that the acquiring platform assigns to the merchant.
     */
    #[JsonProperty('merchantId')]
    public ?string $merchantId;

    /**
     * @var ProcessingTransactionAmounts $transactionAmounts Object that contains information about transaction amounts for the processing account.
     */
    #[JsonProperty('transactionAmounts')]
    public ProcessingTransactionAmounts $transactionAmounts;

    /**
     * @var ProcessingMonthlyAmounts $monthlyAmounts Object that contains information about the monthly processing amounts for the processing account.
     */
    #[JsonProperty('monthlyAmounts')]
    public ProcessingMonthlyAmounts $monthlyAmounts;

    /**
     * @var ProcessingVolumeBreakdown $volumeBreakdown Object that contains information about the types of transactions ran by the processing account. The percentages for transaction types must total 100%.
     */
    #[JsonProperty('volumeBreakdown')]
    public ProcessingVolumeBreakdown $volumeBreakdown;

    /**
     * @var ?bool $isSeasonal Indicates if the processing account runs transactions on a seasonal basis. For example, if the processing account runs transactions during only the winter months, send a value of `true`.
     */
    #[JsonProperty('isSeasonal')]
    public ?bool $isSeasonal;

    /**
     * @var ?array<value-of<ProcessingMonthsOfOperationItem>> $monthsOfOperation Months of the year that the processing account runs transactions.
     */
    #[JsonProperty('monthsOfOperation'), ArrayType(['string'])]
    public ?array $monthsOfOperation;

    /**
     * @var ?ProcessingAch $ach Object that contains information about Automated Clearing House (ACH) transactions.
     */
    #[JsonProperty('ach')]
    public ?ProcessingAch $ach;

    /**
     * @var ?ProcessingCardAcceptance $cardAcceptance Object that contains information about the types of cards that the processing account accepts.
     */
    #[JsonProperty('cardAcceptance')]
    public ?ProcessingCardAcceptance $cardAcceptance;

    /**
     * @param array{
     *   transactionAmounts: ProcessingTransactionAmounts,
     *   monthlyAmounts: ProcessingMonthlyAmounts,
     *   volumeBreakdown: ProcessingVolumeBreakdown,
     *   merchantId?: ?string,
     *   isSeasonal?: ?bool,
     *   monthsOfOperation?: ?array<value-of<ProcessingMonthsOfOperationItem>>,
     *   ach?: ?ProcessingAch,
     *   cardAcceptance?: ?ProcessingCardAcceptance,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->merchantId = $values['merchantId'] ?? null;
        $this->transactionAmounts = $values['transactionAmounts'];
        $this->monthlyAmounts = $values['monthlyAmounts'];
        $this->volumeBreakdown = $values['volumeBreakdown'];
        $this->isSeasonal = $values['isSeasonal'] ?? null;
        $this->monthsOfOperation = $values['monthsOfOperation'] ?? null;
        $this->ach = $values['ach'] ?? null;
        $this->cardAcceptance = $values['cardAcceptance'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
