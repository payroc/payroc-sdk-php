<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the customer’s payment card.
 */
class CardPayload extends JsonSerializableType
{
    /**
     * Indicates the customer’s account type.
     *
     * **Note:** Send a value for accountType only for bank account details.
     *
     * @var ?value-of<CardPayloadAccountType> $accountType
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * @var CardPayloadCardDetails $cardDetails Object that contains the details of the payment card.
     */
    #[JsonProperty('cardDetails')]
    public CardPayloadCardDetails $cardDetails;

    /**
     * @param array{
     *   cardDetails: CardPayloadCardDetails,
     *   accountType?: ?value-of<CardPayloadAccountType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountType = $values['accountType'] ?? null;
        $this->cardDetails = $values['cardDetails'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
