<?php

namespace Payroc\PaymentFeatures\Cards\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\CardPayload;
use Payroc\Types\SecureTokenPayload;
use Payroc\Types\DigitalWalletPayload;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the customer's payment details.
 */
class FxRateInquiryPaymentMethod extends JsonSerializableType
{
    /**
     * @var (
     *    'card'
     *   |'secureToken'
     *   |'digitalWallet'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    CardPayload
     *   |SecureTokenPayload
     *   |DigitalWalletPayload
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'card'
     *   |'secureToken'
     *   |'digitalWallet'
     *   |'_unknown'
     * ),
     *   value: (
     *    CardPayload
     *   |SecureTokenPayload
     *   |DigitalWalletPayload
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->value = $values['value'];
    }

    /**
     * @param CardPayload $card
     * @return FxRateInquiryPaymentMethod
     */
    public static function card(CardPayload $card): FxRateInquiryPaymentMethod
    {
        return new FxRateInquiryPaymentMethod([
            'type' => 'card',
            'value' => $card,
        ]);
    }

    /**
     * @param SecureTokenPayload $secureToken
     * @return FxRateInquiryPaymentMethod
     */
    public static function secureToken(SecureTokenPayload $secureToken): FxRateInquiryPaymentMethod
    {
        return new FxRateInquiryPaymentMethod([
            'type' => 'secureToken',
            'value' => $secureToken,
        ]);
    }

    /**
     * @param DigitalWalletPayload $digitalWallet
     * @return FxRateInquiryPaymentMethod
     */
    public static function digitalWallet(DigitalWalletPayload $digitalWallet): FxRateInquiryPaymentMethod
    {
        return new FxRateInquiryPaymentMethod([
            'type' => 'digitalWallet',
            'value' => $digitalWallet,
        ]);
    }

    /**
     * @return bool
     */
    public function isCard(): bool
    {
        return $this->value instanceof CardPayload && $this->type === 'card';
    }

    /**
     * @return CardPayload
     */
    public function asCard(): CardPayload
    {
        if (!($this->value instanceof CardPayload && $this->type === 'card')) {
            throw new Exception(
                "Expected card; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isSecureToken(): bool
    {
        return $this->value instanceof SecureTokenPayload && $this->type === 'secureToken';
    }

    /**
     * @return SecureTokenPayload
     */
    public function asSecureToken(): SecureTokenPayload
    {
        if (!($this->value instanceof SecureTokenPayload && $this->type === 'secureToken')) {
            throw new Exception(
                "Expected secureToken; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isDigitalWallet(): bool
    {
        return $this->value instanceof DigitalWalletPayload && $this->type === 'digitalWallet';
    }

    /**
     * @return DigitalWalletPayload
     */
    public function asDigitalWallet(): DigitalWalletPayload
    {
        if (!($this->value instanceof DigitalWalletPayload && $this->type === 'digitalWallet')) {
            throw new Exception(
                "Expected digitalWallet; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        $result = [];
        $result['type'] = $this->type;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->type) {
            case 'card':
                $value = $this->asCard()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'secureToken':
                $value = $this->asSecureToken()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'digitalWallet':
                $value = $this->asDigitalWallet()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case '_unknown':
            default:
                if (is_null($this->value)) {
                    break;
                }
                if ($this->value instanceof JsonSerializableType) {
                    $value = $this->value->jsonSerialize();
                    $result = array_merge($value, $result);
                } elseif (is_array($this->value)) {
                    $result = array_merge($this->value, $result);
                }
        }

        return $result;
    }

    /**
     * @param string $json
     */
    public static function fromJson(string $json): static
    {
        $decodedJson = JsonDecoder::decode($json);
        if (!is_array($decodedJson)) {
            throw new Exception("Unexpected non-array decoded type: " . gettype($decodedJson));
        }
        return self::jsonDeserialize($decodedJson);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function jsonDeserialize(array $data): static
    {
        $args = [];
        if (!array_key_exists('type', $data)) {
            throw new Exception(
                "JSON data is missing property 'type'",
            );
        }
        $type = $data['type'];
        if (!(is_string($type))) {
            throw new Exception(
                "Expected property 'type' in JSON data to be string, instead received " . get_debug_type($data['type']),
            );
        }

        $args['type'] = $type;
        switch ($type) {
            case 'card':
                $args['value'] = CardPayload::jsonDeserialize($data);
                break;
            case 'secureToken':
                $args['value'] = SecureTokenPayload::jsonDeserialize($data);
                break;
            case 'digitalWallet':
                $args['value'] = DigitalWalletPayload::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['type'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
