<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the encrypted swiped card data.
 */
class EncryptedSwipedDataFormat extends JsonSerializableType
{
    /**
     * @var EncryptionCapableDevice $device
     */
    #[JsonProperty('device')]
    public EncryptionCapableDevice $device;

    /**
     * @var string $encryptedData Encrypted data received from the magnetic stripe reader.
     */
    #[JsonProperty('encryptedData')]
    public string $encryptedData;

    /**
     * @var ?string $firstDigitOfPan First digit of the of the card number.
     */
    #[JsonProperty('firstDigitOfPan')]
    public ?string $firstDigitOfPan;

    /**
     * @var ?bool $fallback Indicates that this is a fallback transaction. For example, if there was a technical issue with the chip on the customer's card and the merchant then swiped the card.
     */
    #[JsonProperty('fallback')]
    public ?bool $fallback;

    /**
     * @var ?value-of<EncryptedSwipedDataFormatFallbackReason> $fallbackReason Reason for the fallback.
     */
    #[JsonProperty('fallbackReason')]
    public ?string $fallbackReason;

    /**
     * @param array{
     *   device: EncryptionCapableDevice,
     *   encryptedData: string,
     *   firstDigitOfPan?: ?string,
     *   fallback?: ?bool,
     *   fallbackReason?: ?value-of<EncryptedSwipedDataFormatFallbackReason>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->device = $values['device'];
        $this->encryptedData = $values['encryptedData'];
        $this->firstDigitOfPan = $values['firstDigitOfPan'] ?? null;
        $this->fallback = $values['fallback'] ?? null;
        $this->fallbackReason = $values['fallbackReason'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
