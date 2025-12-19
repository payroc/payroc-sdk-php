<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Foreign exchange rate for the transaction.
 */
class FxRate extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who ran the transaction.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var int $baseAmount Total amount of the transaction in the local currency. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('baseAmount')]
    public int $baseAmount;

    /**
     * @var value-of<Currency> $baseCurrency
     */
    #[JsonProperty('baseCurrency')]
    public string $baseCurrency;

    /**
     * @var FxRateInquiryResult $inquiryResult
     */
    #[JsonProperty('inquiryResult')]
    public FxRateInquiryResult $inquiryResult;

    /**
     * @var ?DccOffer $dccOffer
     */
    #[JsonProperty('dccOffer')]
    public ?DccOffer $dccOffer;

    /**
     * @var CardInfo $cardInfo
     */
    #[JsonProperty('cardInfo')]
    public CardInfo $cardInfo;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   baseAmount: int,
     *   baseCurrency: value-of<Currency>,
     *   inquiryResult: FxRateInquiryResult,
     *   cardInfo: CardInfo,
     *   operator?: ?string,
     *   dccOffer?: ?DccOffer,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->baseAmount = $values['baseAmount'];
        $this->baseCurrency = $values['baseCurrency'];
        $this->inquiryResult = $values['inquiryResult'];
        $this->dccOffer = $values['dccOffer'] ?? null;
        $this->cardInfo = $values['cardInfo'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
