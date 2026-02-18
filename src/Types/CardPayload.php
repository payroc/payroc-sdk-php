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
     * Polymorphic object that contains payment card information.
     *
     * The value of the entryMethod parameter determines which variant you should use:
     * - `raw` - Unencrypted payment data directly from the device.
     * - `icc` - Payment data that the device captured from the chip.
     * - `keyed` - Payment data that the merchant entered manually.
     * - `swiped` - Payment data that the device captured from the magnetic strip.
     *
     * @var CardPayloadCardDetails $cardDetails
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
