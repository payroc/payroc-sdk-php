<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the encrypted card data for keyed transactions.
 */
class FullyEncryptedKeyedDataFormat extends JsonSerializableType
{
    /**
     * @var EncryptionCapableDevice $device
     */
    #[JsonProperty('device')]
    public EncryptionCapableDevice $device;

    /**
     * @var string $encryptedData Encrypted card data.
     */
    #[JsonProperty('encryptedData')]
    public string $encryptedData;

    /**
     * @var ?string $firstDigitOfPan First digit of the customer’s card number.
     */
    #[JsonProperty('firstDigitOfPan')]
    public ?string $firstDigitOfPan;

    /**
     * @param array{
     *   device: EncryptionCapableDevice,
     *   encryptedData: string,
     *   firstDigitOfPan?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->device = $values['device'];
        $this->encryptedData = $values['encryptedData'];
        $this->firstDigitOfPan = $values['firstDigitOfPan'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
