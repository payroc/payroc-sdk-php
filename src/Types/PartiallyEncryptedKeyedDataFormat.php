<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the partially-encrypted card data for keyed transactions.
 */
class PartiallyEncryptedKeyedDataFormat extends JsonSerializableType
{
    /**
     * @var EncryptionCapableDevice $device
     */
    #[JsonProperty('device')]
    public EncryptionCapableDevice $device;

    /**
     * @var string $encryptedPan Encrypted card number.
     */
    #[JsonProperty('encryptedPan')]
    public string $encryptedPan;

    /**
     * Masked card number.
     * The gateway shows only the first six digits and the last four digits of the account number. For example, `453985******7062`.
     *
     * @var string $maskedPan
     */
    #[JsonProperty('maskedPan')]
    public string $maskedPan;

    /**
     * @var string $expiryDate Expiry date of the customer’s card.
     */
    #[JsonProperty('expiryDate')]
    public string $expiryDate;

    /**
     * @var ?string $cvv Security code of the customer’s card.
     */
    #[JsonProperty('cvv')]
    public ?string $cvv;

    /**
     * @var ?string $cvvEncrypted Encrypted security code data.
     */
    #[JsonProperty('cvvEncrypted')]
    public ?string $cvvEncrypted;

    /**
     * @var ?string $issueNumber Issue number of the customer’s card.
     */
    #[JsonProperty('issueNumber')]
    public ?string $issueNumber;

    /**
     * @param array{
     *   device: EncryptionCapableDevice,
     *   encryptedPan: string,
     *   maskedPan: string,
     *   expiryDate: string,
     *   cvv?: ?string,
     *   cvvEncrypted?: ?string,
     *   issueNumber?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->device = $values['device'];
        $this->encryptedPan = $values['encryptedPan'];
        $this->maskedPan = $values['maskedPan'];
        $this->expiryDate = $values['expiryDate'];
        $this->cvv = $values['cvv'] ?? null;
        $this->cvvEncrypted = $values['cvvEncrypted'] ?? null;
        $this->issueNumber = $values['issueNumber'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
