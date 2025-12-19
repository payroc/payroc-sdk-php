<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the payment details in the customer’s digital wallet.
 */
class DigitalWalletPayload extends JsonSerializableType
{
    /**
     * Indicates the customer’s account type.
     *
     * **Note:** Send a value for accountType only for bank account details.
     *
     * @var ?value-of<DigitalWalletPayloadAccountType> $accountType
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * Provider of the digital wallet. Send one of the following values:
     * - `apple` - For more information about how to integrate with Apple Pay, go to [Apple Pay®](https://docs.payroc.com/guides/integrate/apple-pay).
     * - `google` - For more information about how to integrate with google Pay, go to [Google Pay®](https://docs.payroc.com/guides/integrate/google-pay).
     *
     * @var value-of<DigitalWalletPayloadServiceProvider> $serviceProvider
     */
    #[JsonProperty('serviceProvider')]
    public string $serviceProvider;

    /**
     * @var ?string $cardholderName Cardholder’s name.
     */
    #[JsonProperty('cardholderName')]
    public ?string $cardholderName;

    /**
     * @var string $encryptedData Encrypted data of the digital wallet.
     */
    #[JsonProperty('encryptedData')]
    public string $encryptedData;

    /**
     * @param array{
     *   serviceProvider: value-of<DigitalWalletPayloadServiceProvider>,
     *   encryptedData: string,
     *   accountType?: ?value-of<DigitalWalletPayloadAccountType>,
     *   cardholderName?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountType = $values['accountType'] ?? null;
        $this->serviceProvider = $values['serviceProvider'];
        $this->cardholderName = $values['cardholderName'] ?? null;
        $this->encryptedData = $values['encryptedData'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
