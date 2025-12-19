<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the customer's card details.
 */
class CardSource extends JsonSerializableType
{
    /**
     * @var string $cardholderName Cardholder's name.
     */
    #[JsonProperty('cardholderName')]
    public string $cardholderName;

    /**
     * @var string $cardNumber Primary account number of the customer's card.
     */
    #[JsonProperty('cardNumber')]
    public string $cardNumber;

    /**
     * @var ?string $expiryDate Expiry date of the customer's card.
     */
    #[JsonProperty('expiryDate')]
    public ?string $expiryDate;

    /**
     * @var ?string $cardType Card brand of the card, for example, Visa.
     */
    #[JsonProperty('cardType')]
    public ?string $cardType;

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
     *   cardholderName: string,
     *   cardNumber: string,
     *   expiryDate?: ?string,
     *   cardType?: ?string,
     *   currency?: ?value-of<Currency>,
     *   debit?: ?bool,
     *   surcharging?: ?Surcharging,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->cardholderName = $values['cardholderName'];
        $this->cardNumber = $values['cardNumber'];
        $this->expiryDate = $values['expiryDate'] ?? null;
        $this->cardType = $values['cardType'] ?? null;
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
