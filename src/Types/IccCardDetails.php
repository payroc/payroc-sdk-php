<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the Integrated Circuit Card (ICC).
 */
class IccCardDetails extends JsonSerializableType
{
    /**
     * If an offline transaction is not approved using the initial entry method, reprocess the transaction using a downgraded entry method.
     * For example, an Integrated Circuit Card (ICC) transaction can be downgraded to a swiped transaction or a keyed transaction.
     *
     * @var ?value-of<IccCardDetailsDowngradeTo> $downgradeTo
     */
    #[JsonProperty('downgradeTo')]
    public ?string $downgradeTo;

    /**
     * @var EncryptionCapableDevice $device
     */
    #[JsonProperty('device')]
    public EncryptionCapableDevice $device;

    /**
     * @var string $iccData Cardholder data from the ICC. The data consists of EMV tags in Tag-Length-Value (TLV) format.
     */
    #[JsonProperty('iccData')]
    public string $iccData;

    /**
     * @var ?string $firstDigitOfPan First digit of the card number.
     */
    #[JsonProperty('firstDigitOfPan')]
    public ?string $firstDigitOfPan;

    /**
     * @var ?string $cardholderSignature Cardholder's signature. For more information about how to format the signature, go to [How to send a signature to our gateway](https://docs.payroc.com/knowledge/basic-concepts/signature-capture).
     */
    #[JsonProperty('cardholderSignature')]
    public ?string $cardholderSignature;

    /**
     * @var ?EbtDetailsWithVoucher $ebtDetails
     */
    #[JsonProperty('ebtDetails')]
    public ?EbtDetailsWithVoucher $ebtDetails;

    /**
     * @param array{
     *   device: EncryptionCapableDevice,
     *   iccData: string,
     *   downgradeTo?: ?value-of<IccCardDetailsDowngradeTo>,
     *   firstDigitOfPan?: ?string,
     *   cardholderSignature?: ?string,
     *   ebtDetails?: ?EbtDetailsWithVoucher,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->downgradeTo = $values['downgradeTo'] ?? null;
        $this->device = $values['device'];
        $this->iccData = $values['iccData'];
        $this->firstDigitOfPan = $values['firstDigitOfPan'] ?? null;
        $this->cardholderSignature = $values['cardholderSignature'] ?? null;
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
