<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the card.
 */
class CardSummary extends JsonSerializableType
{
    /**
     * @var ?string $cardNumber Masked card number. Our gateway shows only the first six digits and the last four digits of the card number, for example, `500165******0000`.
     */
    #[JsonProperty('cardNumber')]
    public ?string $cardNumber;

    /**
     * Card type, for example, Visa.
     *
     * **Note:** If we can’t match a dispute to a transaction, we don’t return a type object.
     *
     * @var ?value-of<CardSummaryType> $type
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?bool $cvvPresenceIndicator Indicates whether the cardholder provided the Card Verification Value (CVV).
     */
    #[JsonProperty('cvvPresenceIndicator')]
    public ?bool $cvvPresenceIndicator;

    /**
     * @var ?bool $avsRequest Indicates whether the merchant used the Address Verification Service (AVS) to verify the cardholder's address.
     */
    #[JsonProperty('avsRequest')]
    public ?bool $avsRequest;

    /**
     * @var ?string $avsResponse Response from the Address Verification Service (AVS).
     */
    #[JsonProperty('avsResponse')]
    public ?string $avsResponse;

    /**
     * @param array{
     *   cardNumber?: ?string,
     *   type?: ?value-of<CardSummaryType>,
     *   cvvPresenceIndicator?: ?bool,
     *   avsRequest?: ?bool,
     *   avsResponse?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->cardNumber = $values['cardNumber'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->cvvPresenceIndicator = $values['cvvPresenceIndicator'] ?? null;
        $this->avsRequest = $values['avsRequest'] ?? null;
        $this->avsResponse = $values['avsResponse'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
