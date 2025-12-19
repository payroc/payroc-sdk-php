<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the keyed card details.
 */
class KeyedCardDetails extends JsonSerializableType
{
    /**
     * @var KeyedCardDetailsKeyedData $keyedData
     */
    #[JsonProperty('keyedData')]
    public KeyedCardDetailsKeyedData $keyedData;

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
     * @var ?KeyedCardDetailsPinDetails $pinDetails
     */
    #[JsonProperty('pinDetails')]
    public ?KeyedCardDetailsPinDetails $pinDetails;

    /**
     * @var ?EbtDetailsWithVoucher $ebtDetails
     */
    #[JsonProperty('ebtDetails')]
    public ?EbtDetailsWithVoucher $ebtDetails;

    /**
     * @param array{
     *   keyedData: KeyedCardDetailsKeyedData,
     *   cardholderName?: ?string,
     *   cardholderSignature?: ?string,
     *   pinDetails?: ?KeyedCardDetailsPinDetails,
     *   ebtDetails?: ?EbtDetailsWithVoucher,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->keyedData = $values['keyedData'];
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
