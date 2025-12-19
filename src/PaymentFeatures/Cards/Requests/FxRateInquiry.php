<?php

namespace Payroc\PaymentFeatures\Cards\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\PaymentFeatures\Cards\Types\FxRateInquiryChannel;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\Currency;
use Payroc\PaymentFeatures\Cards\Types\FxRateInquiryPaymentMethod;

class FxRateInquiry extends JsonSerializableType
{
    /**
     * @var value-of<FxRateInquiryChannel> $channel Channel that the merchant used to receive payment details for the transaction.
     */
    #[JsonProperty('channel')]
    public string $channel;

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
     * @var int $baseAmount Total amount of the transaction in the merchant’s currency. The value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('baseAmount')]
    public int $baseAmount;

    /**
     * @var value-of<Currency> $baseCurrency
     */
    #[JsonProperty('baseCurrency')]
    public string $baseCurrency;

    /**
     * @var FxRateInquiryPaymentMethod $paymentMethod Object that contains information about the customer's payment details.
     */
    #[JsonProperty('paymentMethod')]
    public FxRateInquiryPaymentMethod $paymentMethod;

    /**
     * @param array{
     *   channel: value-of<FxRateInquiryChannel>,
     *   processingTerminalId: string,
     *   baseAmount: int,
     *   baseCurrency: value-of<Currency>,
     *   paymentMethod: FxRateInquiryPaymentMethod,
     *   operator?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->channel = $values['channel'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->baseAmount = $values['baseAmount'];
        $this->baseCurrency = $values['baseCurrency'];
        $this->paymentMethod = $values['paymentMethod'];
    }
}
