<?php

namespace Payroc\PaymentFeatures\Cards\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\Currency;
use Payroc\PaymentFeatures\Cards\Types\BinLookupCard;

class BinLookup extends JsonSerializableType
{
    /**
     * @var ?string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public ?string $processingTerminalId;

    /**
     * @var ?int $amount Transaction amount that you send to check the surcharge amount. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var BinLookupCard $card Object that contains information about the card.
     */
    #[JsonProperty('card')]
    public BinLookupCard $card;

    /**
     * @param array{
     *   card: BinLookupCard,
     *   processingTerminalId?: ?string,
     *   amount?: ?int,
     *   currency?: ?value-of<Currency>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->card = $values['card'];
    }
}
