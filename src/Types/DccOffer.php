<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the dynamic currency conversion (DCC) offer.
 *
 * For more information about DCC, go to [Dynamic Currency Conversion](https://docs.payroc.com/knowledge/card-payments/dynamic-currency-conversion).
 */
class DccOffer extends JsonSerializableType
{
    /**
     * @var ?bool $accepted Indicates if the cardholder accepted DCC offer.
     */
    #[JsonProperty('accepted')]
    public ?bool $accepted;

    /**
     * @var ?string $offerReference Unique identifier of the DCC offer.
     */
    #[JsonProperty('offerReference')]
    public ?string $offerReference;

    /**
     * @var int $fxAmount Amount in the cardholder’s currency in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('fxAmount')]
    public int $fxAmount;

    /**
     * @var value-of<Currency> $fxCurrency Currency of the transaction in the card’s currency. The value for the currency follows the [ISO 4217](https://www.iso.org/iso-4217-currency-codes.html) standard.
     */
    #[JsonProperty('fxCurrency')]
    public string $fxCurrency;

    /**
     * @var ?string $fxCurrencyCode Three-digit currency code for the card. This code follows the [ISO 4217](https://www.iso.org/iso-4217-currency-codes.html) standard.
     */
    #[JsonProperty('fxCurrencyCode')]
    public ?string $fxCurrencyCode;

    /**
     * Number of decimal places between the smallest currency unit and a whole currency unit.
     *
     * For example, for GBP, the smallest currency unit is 1p and it is equal to £0.01.
     * If you use GBP, the value for **fxCurrencyExponent** is 2.
     *
     * @var ?int $fxCurrencyExponent
     */
    #[JsonProperty('fxCurrencyExponent')]
    public ?int $fxCurrencyExponent;

    /**
     * @var float $fxRate Foreign exchange rate for the card's currency.
     */
    #[JsonProperty('fxRate')]
    public float $fxRate;

    /**
     * @var float $markup Markup percentage rate that the DCC provider applies to the foreign exchange rate.
     */
    #[JsonProperty('markup')]
    public float $markup;

    /**
     * @var ?string $markupText Supporting text for the markup rate.
     */
    #[JsonProperty('markupText')]
    public ?string $markupText;

    /**
     * @var ?string $provider Name of the DCC provider.
     */
    #[JsonProperty('provider')]
    public ?string $provider;

    /**
     * @var ?string $source Source that the DCC provider used to get the foreign exchange rates.
     */
    #[JsonProperty('source')]
    public ?string $source;

    /**
     * @param array{
     *   fxAmount: int,
     *   fxCurrency: value-of<Currency>,
     *   fxRate: float,
     *   markup: float,
     *   accepted?: ?bool,
     *   offerReference?: ?string,
     *   fxCurrencyCode?: ?string,
     *   fxCurrencyExponent?: ?int,
     *   markupText?: ?string,
     *   provider?: ?string,
     *   source?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accepted = $values['accepted'] ?? null;
        $this->offerReference = $values['offerReference'] ?? null;
        $this->fxAmount = $values['fxAmount'];
        $this->fxCurrency = $values['fxCurrency'];
        $this->fxCurrencyCode = $values['fxCurrencyCode'] ?? null;
        $this->fxCurrencyExponent = $values['fxCurrencyExponent'] ?? null;
        $this->fxRate = $values['fxRate'];
        $this->markup = $values['markup'];
        $this->markupText = $values['markupText'] ?? null;
        $this->provider = $values['provider'] ?? null;
        $this->source = $values['source'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
