<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the customer’s card details for swiped transactions.
 */
class SwipedCardDetails extends JsonSerializableType
{
    /**
     * If an offline transaction is not approved using the initial entry method, reprocess the transaction using a downgraded entry method.
     * For example, a swiped transaction can be downgraded to a keyed transaction.
     *
     * @var ?value-of<SwipedCardDetailsDowngradeTo> $downgradeTo
     */
    #[JsonProperty('downgradeTo')]
    public ?string $downgradeTo;

    /**
     * @var SwipedCardDetailsSwipedData $swipedData
     */
    #[JsonProperty('swipedData')]
    public SwipedCardDetailsSwipedData $swipedData;

    /**
     * @var ?string $cardholderName Cardholder’s name.
     */
    #[JsonProperty('cardholderName')]
    public ?string $cardholderName;

    /**
     * @var ?string $cardholderSignature Cardholder's signature. For more information about how to format the signature, go to [How to send a signature to our gateway](https://docs.payroc.com/knowledge/basic-concepts/signature-capture).
     */
    #[JsonProperty('cardholderSignature')]
    public ?string $cardholderSignature;

    /**
     * @var ?SwipedCardDetailsPinDetails $pinDetails
     */
    #[JsonProperty('pinDetails')]
    public ?SwipedCardDetailsPinDetails $pinDetails;

    /**
     * @var ?EbtDetailsWithVoucher $ebtDetails
     */
    #[JsonProperty('ebtDetails')]
    public ?EbtDetailsWithVoucher $ebtDetails;

    /**
     * @param array{
     *   swipedData: SwipedCardDetailsSwipedData,
     *   downgradeTo?: ?value-of<SwipedCardDetailsDowngradeTo>,
     *   cardholderName?: ?string,
     *   cardholderSignature?: ?string,
     *   pinDetails?: ?SwipedCardDetailsPinDetails,
     *   ebtDetails?: ?EbtDetailsWithVoucher,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->downgradeTo = $values['downgradeTo'] ?? null;
        $this->swipedData = $values['swipedData'];
        $this->cardholderName = $values['cardholderName'] ?? null;
        $this->cardholderSignature = $values['cardholderSignature'] ?? null;
        $this->pinDetails = $values['pinDetails'] ?? null;
        $this->ebtDetails = $values['ebtDetails'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
