<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Union;

/**
 * Object that contains the feature settings for the terminal.
 */
class ProcessingTerminalFeatures extends JsonSerializableType
{
    /**
     * @var (
     *    TipProcessingEnabled
     *   |TipProcessingDisabled
     * )|null $tips Object that contains the tip settings for the processing terminal.
     */
    #[JsonProperty('tips'), Union(TipProcessingEnabled::class, TipProcessingDisabled::class, 'null')]
    public TipProcessingEnabled|TipProcessingDisabled|null $tips;

    /**
     * @var ProcessingTerminalFeaturesEnhancedProcessing $enhancedProcessing Object that contains details about level two and level three transactions.
     */
    #[JsonProperty('enhancedProcessing')]
    public ProcessingTerminalFeaturesEnhancedProcessing $enhancedProcessing;

    /**
     * @var (
     *    EbtEnabled
     *   |EbtDisabled
     * ) $ebt Object that contains details about EBT transactions.
     */
    #[JsonProperty('ebt'), Union(EbtEnabled::class, EbtDisabled::class)]
    public EbtEnabled|EbtDisabled $ebt;

    /**
     * @var bool $pinDebitCashback Indicates if the terminal prompts for cashback on PIN debit transactions.
     */
    #[JsonProperty('pinDebitCashback')]
    public bool $pinDebitCashback;

    /**
     * @var ?bool $recurringPayments Indicates if the terminal can run repeat payments. For more information about repeat payments, go to [Payment Plans](https://docs.payroc.com/guides/integrate/repeat-payments).
     */
    #[JsonProperty('recurringPayments')]
    public ?bool $recurringPayments;

    /**
     * @var ?ProcessingTerminalFeaturesPaymentLinks $paymentLinks Object that contains details about payment links.
     */
    #[JsonProperty('paymentLinks')]
    public ?ProcessingTerminalFeaturesPaymentLinks $paymentLinks;

    /**
     * @var ?bool $preAuthorizations Indicates if the terminal can run pre-authorizations.
     */
    #[JsonProperty('preAuthorizations')]
    public ?bool $preAuthorizations;

    /**
     * @var ?bool $offlinePayments Indicates if the terminal can accept payments when it can't connect to the gateway. For more information about offline processing, go to [Offline Processing](https://docs.payroc.com/knowledge/card-payments/offline-processing).
     */
    #[JsonProperty('offlinePayments')]
    public ?bool $offlinePayments;

    /**
     * @param array{
     *   enhancedProcessing: ProcessingTerminalFeaturesEnhancedProcessing,
     *   ebt: (
     *    EbtEnabled
     *   |EbtDisabled
     * ),
     *   pinDebitCashback: bool,
     *   tips?: (
     *    TipProcessingEnabled
     *   |TipProcessingDisabled
     * )|null,
     *   recurringPayments?: ?bool,
     *   paymentLinks?: ?ProcessingTerminalFeaturesPaymentLinks,
     *   preAuthorizations?: ?bool,
     *   offlinePayments?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->tips = $values['tips'] ?? null;
        $this->enhancedProcessing = $values['enhancedProcessing'];
        $this->ebt = $values['ebt'];
        $this->pinDebitCashback = $values['pinDebitCashback'];
        $this->recurringPayments = $values['recurringPayments'] ?? null;
        $this->paymentLinks = $values['paymentLinks'] ?? null;
        $this->preAuthorizations = $values['preAuthorizations'] ?? null;
        $this->offlinePayments = $values['offlinePayments'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
