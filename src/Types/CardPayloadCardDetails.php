<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains the details of the payment card.
 */
class CardPayloadCardDetails extends JsonSerializableType
{
    /**
     * @var (
     *    'raw'
     *   |'icc'
     *   |'keyed'
     *   |'swiped'
     *   |'_unknown'
     * ) $entryMethod
     */
    public readonly string $entryMethod;

    /**
     * @var (
     *    RawCardDetails
     *   |IccCardDetails
     *   |KeyedCardDetails
     *   |SwipedCardDetails
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   entryMethod: (
     *    'raw'
     *   |'icc'
     *   |'keyed'
     *   |'swiped'
     *   |'_unknown'
     * ),
     *   value: (
     *    RawCardDetails
     *   |IccCardDetails
     *   |KeyedCardDetails
     *   |SwipedCardDetails
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->entryMethod = $values['entryMethod'];
        $this->value = $values['value'];
    }

    /**
     * @param RawCardDetails $raw
     * @return CardPayloadCardDetails
     */
    public static function raw(RawCardDetails $raw): CardPayloadCardDetails
    {
        return new CardPayloadCardDetails([
            'entryMethod' => 'raw',
            'value' => $raw,
        ]);
    }

    /**
     * @param IccCardDetails $icc
     * @return CardPayloadCardDetails
     */
    public static function icc(IccCardDetails $icc): CardPayloadCardDetails
    {
        return new CardPayloadCardDetails([
            'entryMethod' => 'icc',
            'value' => $icc,
        ]);
    }

    /**
     * @param KeyedCardDetails $keyed
     * @return CardPayloadCardDetails
     */
    public static function keyed(KeyedCardDetails $keyed): CardPayloadCardDetails
    {
        return new CardPayloadCardDetails([
            'entryMethod' => 'keyed',
            'value' => $keyed,
        ]);
    }

    /**
     * @param SwipedCardDetails $swiped
     * @return CardPayloadCardDetails
     */
    public static function swiped(SwipedCardDetails $swiped): CardPayloadCardDetails
    {
        return new CardPayloadCardDetails([
            'entryMethod' => 'swiped',
            'value' => $swiped,
        ]);
    }

    /**
     * @return bool
     */
    public function isRaw(): bool
    {
        return $this->value instanceof RawCardDetails && $this->entryMethod === 'raw';
    }

    /**
     * @return RawCardDetails
     */
    public function asRaw(): RawCardDetails
    {
        if (!($this->value instanceof RawCardDetails && $this->entryMethod === 'raw')) {
            throw new Exception(
                "Expected raw; got " . $this->entryMethod . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isIcc(): bool
    {
        return $this->value instanceof IccCardDetails && $this->entryMethod === 'icc';
    }

    /**
     * @return IccCardDetails
     */
    public function asIcc(): IccCardDetails
    {
        if (!($this->value instanceof IccCardDetails && $this->entryMethod === 'icc')) {
            throw new Exception(
                "Expected icc; got " . $this->entryMethod . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isKeyed(): bool
    {
        return $this->value instanceof KeyedCardDetails && $this->entryMethod === 'keyed';
    }

    /**
     * @return KeyedCardDetails
     */
    public function asKeyed(): KeyedCardDetails
    {
        if (!($this->value instanceof KeyedCardDetails && $this->entryMethod === 'keyed')) {
            throw new Exception(
                "Expected keyed; got " . $this->entryMethod . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isSwiped(): bool
    {
        return $this->value instanceof SwipedCardDetails && $this->entryMethod === 'swiped';
    }

    /**
     * @return SwipedCardDetails
     */
    public function asSwiped(): SwipedCardDetails
    {
        if (!($this->value instanceof SwipedCardDetails && $this->entryMethod === 'swiped')) {
            throw new Exception(
                "Expected swiped; got " . $this->entryMethod . " with value of type " . get_debug_type($this->value),
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
        $result['entryMethod'] = $this->entryMethod;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->entryMethod) {
            case 'raw':
                $value = $this->asRaw()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'icc':
                $value = $this->asIcc()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'keyed':
                $value = $this->asKeyed()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'swiped':
                $value = $this->asSwiped()->jsonSerialize();
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
        if (!array_key_exists('entryMethod', $data)) {
            throw new Exception(
                "JSON data is missing property 'entryMethod'",
            );
        }
        $entryMethod = $data['entryMethod'];
        if (!(is_string($entryMethod))) {
            throw new Exception(
                "Expected property 'entryMethod' in JSON data to be string, instead received " . get_debug_type($data['entryMethod']),
            );
        }

        $args['entryMethod'] = $entryMethod;
        switch ($entryMethod) {
            case 'raw':
                $args['value'] = RawCardDetails::jsonDeserialize($data);
                break;
            case 'icc':
                $args['value'] = IccCardDetails::jsonDeserialize($data);
                break;
            case 'keyed':
                $args['value'] = KeyedCardDetails::jsonDeserialize($data);
                break;
            case 'swiped':
                $args['value'] = SwipedCardDetails::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['entryMethod'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
