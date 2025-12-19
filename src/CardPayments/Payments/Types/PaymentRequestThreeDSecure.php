<?php

namespace Payroc\CardPayments\Payments\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\GatewayThreeDSecure;
use Payroc\Types\ThirdPartyThreeDSecure;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information for an authentication check on the customer's payment details using the 3-D Secure protocol.
 */
class PaymentRequestThreeDSecure extends JsonSerializableType
{
    /**
     * @var (
     *    'gateway'
     *   |'thirdParty'
     *   |'_unknown'
     * ) $serviceProvider
     */
    public readonly string $serviceProvider;

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
     *   serviceProvider: (
     *    'gateway'
     *   |'thirdParty'
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
        $this->serviceProvider = $values['serviceProvider'];
        $this->value = $values['value'];
    }

    /**
     * @param GatewayThreeDSecure $gateway
     * @return PaymentRequestThreeDSecure
     */
    public static function gateway(GatewayThreeDSecure $gateway): PaymentRequestThreeDSecure
    {
        return new PaymentRequestThreeDSecure([
            'serviceProvider' => 'gateway',
            'value' => $gateway,
        ]);
    }

    /**
     * @param ThirdPartyThreeDSecure $thirdParty
     * @return PaymentRequestThreeDSecure
     */
    public static function thirdParty(ThirdPartyThreeDSecure $thirdParty): PaymentRequestThreeDSecure
    {
        return new PaymentRequestThreeDSecure([
            'serviceProvider' => 'thirdParty',
            'value' => $thirdParty,
        ]);
    }

    /**
     * @return bool
     */
    public function isGateway(): bool
    {
        return $this->value instanceof GatewayThreeDSecure && $this->serviceProvider === 'gateway';
    }

    /**
     * @return GatewayThreeDSecure
     */
    public function asGateway(): GatewayThreeDSecure
    {
        if (!($this->value instanceof GatewayThreeDSecure && $this->serviceProvider === 'gateway')) {
            throw new Exception(
                "Expected gateway; got " . $this->serviceProvider . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isThirdParty(): bool
    {
        return $this->value instanceof ThirdPartyThreeDSecure && $this->serviceProvider === 'thirdParty';
    }

    /**
     * @return ThirdPartyThreeDSecure
     */
    public function asThirdParty(): ThirdPartyThreeDSecure
    {
        if (!($this->value instanceof ThirdPartyThreeDSecure && $this->serviceProvider === 'thirdParty')) {
            throw new Exception(
                "Expected thirdParty; got " . $this->serviceProvider . " with value of type " . get_debug_type($this->value),
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
        $result['serviceProvider'] = $this->serviceProvider;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->serviceProvider) {
            case 'gateway':
                $value = $this->asGateway()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'thirdParty':
                $value = $this->asThirdParty()->jsonSerialize();
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
        if (!array_key_exists('serviceProvider', $data)) {
            throw new Exception(
                "JSON data is missing property 'serviceProvider'",
            );
        }
        $serviceProvider = $data['serviceProvider'];
        if (!(is_string($serviceProvider))) {
            throw new Exception(
                "Expected property 'serviceProvider' in JSON data to be string, instead received " . get_debug_type($data['serviceProvider']),
            );
        }

        $args['serviceProvider'] = $serviceProvider;
        switch ($serviceProvider) {
            case 'gateway':
                $args['value'] = GatewayThreeDSecure::jsonDeserialize($data);
                break;
            case 'thirdParty':
                $args['value'] = ThirdPartyThreeDSecure::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['serviceProvider'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
