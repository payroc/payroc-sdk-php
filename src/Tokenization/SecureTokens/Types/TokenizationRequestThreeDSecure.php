<?php

namespace Payroc\Tokenization\SecureTokens\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\GatewayThreeDSecure;
use Payroc\Types\ThirdPartyThreeDSecure;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information for an authentication check on the customer's payment details using the 3-D Secure protocol.
 */
class TokenizationRequestThreeDSecure extends JsonSerializableType
{
    /**
     * @var (
     *    'gatewayThreeDSecure'
     *   |'thirdPartyThreeDSecure'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    GatewayThreeDSecure
     *   |ThirdPartyThreeDSecure
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'gatewayThreeDSecure'
     *   |'thirdPartyThreeDSecure'
     *   |'_unknown'
     * ),
     *   value: (
     *    GatewayThreeDSecure
     *   |ThirdPartyThreeDSecure
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
     * @param GatewayThreeDSecure $gatewayThreeDSecure
     * @return TokenizationRequestThreeDSecure
     */
    public static function gatewayThreeDSecure(GatewayThreeDSecure $gatewayThreeDSecure): TokenizationRequestThreeDSecure
    {
        return new TokenizationRequestThreeDSecure([
            'type' => 'gatewayThreeDSecure',
            'value' => $gatewayThreeDSecure,
        ]);
    }

    /**
     * @param ThirdPartyThreeDSecure $thirdPartyThreeDSecure
     * @return TokenizationRequestThreeDSecure
     */
    public static function thirdPartyThreeDSecure(ThirdPartyThreeDSecure $thirdPartyThreeDSecure): TokenizationRequestThreeDSecure
    {
        return new TokenizationRequestThreeDSecure([
            'type' => 'thirdPartyThreeDSecure',
            'value' => $thirdPartyThreeDSecure,
        ]);
    }

    /**
     * @return bool
     */
    public function isGatewayThreeDSecure(): bool
    {
        return $this->value instanceof GatewayThreeDSecure && $this->type === 'gatewayThreeDSecure';
    }

    /**
     * @return GatewayThreeDSecure
     */
    public function asGatewayThreeDSecure(): GatewayThreeDSecure
    {
        if (!($this->value instanceof GatewayThreeDSecure && $this->type === 'gatewayThreeDSecure')) {
            throw new Exception(
                "Expected gatewayThreeDSecure; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isThirdPartyThreeDSecure(): bool
    {
        return $this->value instanceof ThirdPartyThreeDSecure && $this->type === 'thirdPartyThreeDSecure';
    }

    /**
     * @return ThirdPartyThreeDSecure
     */
    public function asThirdPartyThreeDSecure(): ThirdPartyThreeDSecure
    {
        if (!($this->value instanceof ThirdPartyThreeDSecure && $this->type === 'thirdPartyThreeDSecure')) {
            throw new Exception(
                "Expected thirdPartyThreeDSecure; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'gatewayThreeDSecure':
                $value = $this->asGatewayThreeDSecure()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'thirdPartyThreeDSecure':
                $value = $this->asThirdPartyThreeDSecure()->jsonSerialize();
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
            case 'gatewayThreeDSecure':
                $args['value'] = GatewayThreeDSecure::jsonDeserialize($data);
                break;
            case 'thirdPartyThreeDSecure':
                $args['value'] = ThirdPartyThreeDSecure::jsonDeserialize($data);
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
