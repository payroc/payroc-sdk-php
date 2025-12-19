<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the payment method that we tokenized.
 */
class SecureTokenSource extends JsonSerializableType
{
    /**
     * @var (
     *    'ach'
     *   |'pad'
     *   |'card'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    AchSource
     *   |PadSource
     *   |CardSource
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'ach'
     *   |'pad'
     *   |'card'
     *   |'_unknown'
     * ),
     *   value: (
     *    AchSource
     *   |PadSource
     *   |CardSource
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
     * @param AchSource $ach
     * @return SecureTokenSource
     */
    public static function ach(AchSource $ach): SecureTokenSource
    {
        return new SecureTokenSource([
            'type' => 'ach',
            'value' => $ach,
        ]);
    }

    /**
     * @param PadSource $pad
     * @return SecureTokenSource
     */
    public static function pad(PadSource $pad): SecureTokenSource
    {
        return new SecureTokenSource([
            'type' => 'pad',
            'value' => $pad,
        ]);
    }

    /**
     * @param CardSource $card
     * @return SecureTokenSource
     */
    public static function card(CardSource $card): SecureTokenSource
    {
        return new SecureTokenSource([
            'type' => 'card',
            'value' => $card,
        ]);
    }

    /**
     * @return bool
     */
    public function isAch(): bool
    {
        return $this->value instanceof AchSource && $this->type === 'ach';
    }

    /**
     * @return AchSource
     */
    public function asAch(): AchSource
    {
        if (!($this->value instanceof AchSource && $this->type === 'ach')) {
            throw new Exception(
                "Expected ach; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPad(): bool
    {
        return $this->value instanceof PadSource && $this->type === 'pad';
    }

    /**
     * @return PadSource
     */
    public function asPad(): PadSource
    {
        if (!($this->value instanceof PadSource && $this->type === 'pad')) {
            throw new Exception(
                "Expected pad; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isCard(): bool
    {
        return $this->value instanceof CardSource && $this->type === 'card';
    }

    /**
     * @return CardSource
     */
    public function asCard(): CardSource
    {
        if (!($this->value instanceof CardSource && $this->type === 'card')) {
            throw new Exception(
                "Expected card; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'pad':
                $value = $this->asPad()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'card':
                $value = $this->asCard()->jsonSerialize();
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
                $args['value'] = AchSource::jsonDeserialize($data);
                break;
            case 'pad':
                $args['value'] = PadSource::jsonDeserialize($data);
                break;
            case 'card':
                $args['value'] = CardSource::jsonDeserialize($data);
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
