<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the unencrypted card details.
 */
class RawCardDetails extends JsonSerializableType
{
    /**
     * If an offline transaction is not approved using the initial entry method, reprocess the transaction using a downgraded entry method.
     * For example, an Integrated Circuit Card (ICC) transaction can be downgraded to a swiped transaction or to a keyed transaction.
     *
     * @var ?value-of<RawCardDetailsDowngradeTo> $downgradeTo
     */
    #[JsonProperty('downgradeTo')]
    public ?string $downgradeTo;

    /**
     * @var Device $device
     */
    #[JsonProperty('device')]
    public Device $device;

    /**
     * @var string $rawData Unencrypted data from the POS terminal.
     */
    #[JsonProperty('rawData')]
    public string $rawData;

    /**
     * @var ?string $cardholderSignature Cardholder's signature. For more information about how to format the signature, go to [How to send a signature to our gateway](https://docs.payroc.com/knowledge/basic-concepts/signature-capture).
     */
    #[JsonProperty('cardholderSignature')]
    public ?string $cardholderSignature;

    /**
     * @param array{
     *   device: Device,
     *   rawData: string,
     *   downgradeTo?: ?value-of<RawCardDetailsDowngradeTo>,
     *   cardholderSignature?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->downgradeTo = $values['downgradeTo'] ?? null;
        $this->device = $values['device'];
        $this->rawData = $values['rawData'];
        $this->cardholderSignature = $values['cardholderSignature'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
