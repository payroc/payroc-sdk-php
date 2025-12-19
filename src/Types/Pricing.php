<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains HATEOAS links to the pricing information that we apply to the processing account.
 */
class Pricing extends JsonSerializableType
{
    /**
     * @var (
     *    'intent'
     *   |'agreement'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    PricingTemplate
     *   |PricingAgreement
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'intent'
     *   |'agreement'
     *   |'_unknown'
     * ),
     *   value: (
     *    PricingTemplate
     *   |PricingAgreement
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
     * @param PricingTemplate $intent
     * @return Pricing
     */
    public static function intent(PricingTemplate $intent): Pricing
    {
        return new Pricing([
            'type' => 'intent',
            'value' => $intent,
        ]);
    }

    /**
     * @param PricingAgreement $agreement
     * @return Pricing
     */
    public static function agreement(PricingAgreement $agreement): Pricing
    {
        return new Pricing([
            'type' => 'agreement',
            'value' => $agreement,
        ]);
    }

    /**
     * @return bool
     */
    public function isIntent(): bool
    {
        return $this->value instanceof PricingTemplate && $this->type === 'intent';
    }

    /**
     * @return PricingTemplate
     */
    public function asIntent(): PricingTemplate
    {
        if (!($this->value instanceof PricingTemplate && $this->type === 'intent')) {
            throw new Exception(
                "Expected intent; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isAgreement(): bool
    {
        return $this->value instanceof PricingAgreement && $this->type === 'agreement';
    }

    /**
     * @return PricingAgreement
     */
    public function asAgreement(): PricingAgreement
    {
        if (!($this->value instanceof PricingAgreement && $this->type === 'agreement')) {
            throw new Exception(
                "Expected agreement; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'intent':
                $value = $this->asIntent()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'agreement':
                $value = $this->asAgreement()->jsonSerialize();
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
            case 'intent':
                $args['value'] = PricingTemplate::jsonDeserialize($data);
                break;
            case 'agreement':
                $args['value'] = PricingAgreement::jsonDeserialize($data);
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
