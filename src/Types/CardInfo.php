<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the card.
 */
class CardInfo extends JsonSerializableType
{
    /**
     * @var string $type Card brand of the card, for example, Visa.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var string $cardNumber Masked card number. Our gateway shows only the first six digits and the last four digits of the card number, for example, 548010******5929.
     */
    #[JsonProperty('cardNumber')]
    public string $cardNumber;

    /**
     * @var ?string $country Country of the issuing bank. The value for the country follows the [ISO-3166-1](https://www.iso.org/iso-3166-country-codes.html) standard.
     */
    #[JsonProperty('country')]
    public ?string $country;

    /**
     * @var ?value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?bool $debit Indicates if the card is a debit card.
     */
    #[JsonProperty('debit')]
    public ?bool $debit;

    /**
     * @var ?Surcharging $surcharging
     */
    #[JsonProperty('surcharging')]
    public ?Surcharging $surcharging;

    /**
     * @param array{
     *   type: string,
     *   cardNumber: string,
     *   country?: ?string,
     *   currency?: ?value-of<Currency>,
     *   debit?: ?bool,
     *   surcharging?: ?Surcharging,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->cardNumber = $values['cardNumber'];
        $this->country = $values['country'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->debit = $values['debit'] ?? null;
        $this->surcharging = $values['surcharging'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
