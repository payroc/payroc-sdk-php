<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains the fees for American Express transactions.
 */
class InterchangePlusTiered3FeesAmex extends JsonSerializableType
{
    /**
     * @var (
     *    'optBlue'
     *   |'direct'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    InterchangePlusTiered3AmexOptBlue
     *   |InterchangePlusTiered3AmexDirect
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'optBlue'
     *   |'direct'
     *   |'_unknown'
     * ),
     *   value: (
     *    InterchangePlusTiered3AmexOptBlue
     *   |InterchangePlusTiered3AmexDirect
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
     * @param InterchangePlusTiered3AmexOptBlue $optBlue
     * @return InterchangePlusTiered3FeesAmex
     */
    public static function optBlue(InterchangePlusTiered3AmexOptBlue $optBlue): InterchangePlusTiered3FeesAmex
    {
        return new InterchangePlusTiered3FeesAmex([
            'type' => 'optBlue',
            'value' => $optBlue,
        ]);
    }

    /**
     * @param InterchangePlusTiered3AmexDirect $direct
     * @return InterchangePlusTiered3FeesAmex
     */
    public static function direct(InterchangePlusTiered3AmexDirect $direct): InterchangePlusTiered3FeesAmex
    {
        return new InterchangePlusTiered3FeesAmex([
            'type' => 'direct',
            'value' => $direct,
        ]);
    }

    /**
     * @return bool
     */
    public function isOptBlue(): bool
    {
        return $this->value instanceof InterchangePlusTiered3AmexOptBlue && $this->type === 'optBlue';
    }

    /**
     * @return InterchangePlusTiered3AmexOptBlue
     */
    public function asOptBlue(): InterchangePlusTiered3AmexOptBlue
    {
        if (!($this->value instanceof InterchangePlusTiered3AmexOptBlue && $this->type === 'optBlue')) {
            throw new Exception(
                "Expected optBlue; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isDirect(): bool
    {
        return $this->value instanceof InterchangePlusTiered3AmexDirect && $this->type === 'direct';
    }

    /**
     * @return InterchangePlusTiered3AmexDirect
     */
    public function asDirect(): InterchangePlusTiered3AmexDirect
    {
        if (!($this->value instanceof InterchangePlusTiered3AmexDirect && $this->type === 'direct')) {
            throw new Exception(
                "Expected direct; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'optBlue':
                $value = $this->asOptBlue()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'direct':
                $value = $this->asDirect()->jsonSerialize();
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
            case 'optBlue':
                $args['value'] = InterchangePlusTiered3AmexOptBlue::jsonDeserialize($data);
                break;
            case 'direct':
                $args['value'] = InterchangePlusTiered3AmexDirect::jsonDeserialize($data);
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
