<?php

namespace Payroc\BankTransferPayments\Payments\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\AchPayload;
use Payroc\Types\SecureTokenPayload;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the customer's payment details.
 */
class RepresentmentPaymentMethod extends JsonSerializableType
{
    /**
     * @var (
     *    'ach'
     *   |'secureToken'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    AchPayload
     *   |SecureTokenPayload
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'ach'
     *   |'secureToken'
     *   |'_unknown'
     * ),
     *   value: (
     *    AchPayload
     *   |SecureTokenPayload
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
     * @param AchPayload $ach
     * @return RepresentmentPaymentMethod
     */
    public static function ach(AchPayload $ach): RepresentmentPaymentMethod
    {
        return new RepresentmentPaymentMethod([
            'type' => 'ach',
            'value' => $ach,
        ]);
    }

    /**
     * @param SecureTokenPayload $secureToken
     * @return RepresentmentPaymentMethod
     */
    public static function secureToken(SecureTokenPayload $secureToken): RepresentmentPaymentMethod
    {
        return new RepresentmentPaymentMethod([
            'type' => 'secureToken',
            'value' => $secureToken,
        ]);
    }

    /**
     * @return bool
     */
    public function isAch(): bool
    {
        return $this->value instanceof AchPayload && $this->type === 'ach';
    }

    /**
     * @return AchPayload
     */
    public function asAch(): AchPayload
    {
        if (!($this->value instanceof AchPayload && $this->type === 'ach')) {
            throw new Exception(
                "Expected ach; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'ach':
                $value = $this->asAch()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'secureToken':
                $value = $this->asSecureToken()->jsonSerialize();
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
            case 'ach':
                $args['value'] = AchPayload::jsonDeserialize($data);
                break;
            case 'secureToken':
                $args['value'] = SecureTokenPayload::jsonDeserialize($data);
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
