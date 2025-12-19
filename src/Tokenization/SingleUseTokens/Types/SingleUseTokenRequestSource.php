<?php

namespace Payroc\Tokenization\SingleUseTokens\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\AchPayload;
use Payroc\Types\PadPayload;
use Payroc\Types\CardPayload;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the payment method to tokenize.
 */
class SingleUseTokenRequestSource extends JsonSerializableType
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
     *    AchPayload
     *   |PadPayload
     *   |CardPayload
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
     *    AchPayload
     *   |PadPayload
     *   |CardPayload
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
     * @return SingleUseTokenRequestSource
     */
    public static function ach(AchPayload $ach): SingleUseTokenRequestSource
    {
        return new SingleUseTokenRequestSource([
            'type' => 'ach',
            'value' => $ach,
        ]);
    }

    /**
     * @param PadPayload $pad
     * @return SingleUseTokenRequestSource
     */
    public static function pad(PadPayload $pad): SingleUseTokenRequestSource
    {
        return new SingleUseTokenRequestSource([
            'type' => 'pad',
            'value' => $pad,
        ]);
    }

    /**
     * @param CardPayload $card
     * @return SingleUseTokenRequestSource
     */
    public static function card(CardPayload $card): SingleUseTokenRequestSource
    {
        return new SingleUseTokenRequestSource([
            'type' => 'card',
            'value' => $card,
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
    public function isPad(): bool
    {
        return $this->value instanceof PadPayload && $this->type === 'pad';
    }

    /**
     * @return PadPayload
     */
    public function asPad(): PadPayload
    {
        if (!($this->value instanceof PadPayload && $this->type === 'pad')) {
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
                $args['value'] = AchPayload::jsonDeserialize($data);
                break;
            case 'pad':
                $args['value'] = PadPayload::jsonDeserialize($data);
                break;
            case 'card':
                $args['value'] = CardPayload::jsonDeserialize($data);
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
