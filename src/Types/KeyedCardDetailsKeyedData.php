<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class KeyedCardDetailsKeyedData extends JsonSerializableType
{
    /**
     * @var (
     *    'fullyEncrypted'
     *   |'partiallyEncrypted'
     *   |'plainText'
     *   |'_unknown'
     * ) $dataFormat
     */
    public readonly string $dataFormat;

    /**
     * @var (
     *    FullyEncryptedKeyedDataFormat
     *   |PartiallyEncryptedKeyedDataFormat
     *   |PlainTextKeyedDataFormat
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   dataFormat: (
     *    'fullyEncrypted'
     *   |'partiallyEncrypted'
     *   |'plainText'
     *   |'_unknown'
     * ),
     *   value: (
     *    FullyEncryptedKeyedDataFormat
     *   |PartiallyEncryptedKeyedDataFormat
     *   |PlainTextKeyedDataFormat
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->dataFormat = $values['dataFormat'];
        $this->value = $values['value'];
    }

    /**
     * @param FullyEncryptedKeyedDataFormat $fullyEncrypted
     * @return KeyedCardDetailsKeyedData
     */
    public static function fullyEncrypted(FullyEncryptedKeyedDataFormat $fullyEncrypted): KeyedCardDetailsKeyedData
    {
        return new KeyedCardDetailsKeyedData([
            'dataFormat' => 'fullyEncrypted',
            'value' => $fullyEncrypted,
        ]);
    }

    /**
     * @param PartiallyEncryptedKeyedDataFormat $partiallyEncrypted
     * @return KeyedCardDetailsKeyedData
     */
    public static function partiallyEncrypted(PartiallyEncryptedKeyedDataFormat $partiallyEncrypted): KeyedCardDetailsKeyedData
    {
        return new KeyedCardDetailsKeyedData([
            'dataFormat' => 'partiallyEncrypted',
            'value' => $partiallyEncrypted,
        ]);
    }

    /**
     * @param PlainTextKeyedDataFormat $plainText
     * @return KeyedCardDetailsKeyedData
     */
    public static function plainText(PlainTextKeyedDataFormat $plainText): KeyedCardDetailsKeyedData
    {
        return new KeyedCardDetailsKeyedData([
            'dataFormat' => 'plainText',
            'value' => $plainText,
        ]);
    }

    /**
     * @return bool
     */
    public function isFullyEncrypted(): bool
    {
        return $this->value instanceof FullyEncryptedKeyedDataFormat && $this->dataFormat === 'fullyEncrypted';
    }

    /**
     * @return FullyEncryptedKeyedDataFormat
     */
    public function asFullyEncrypted(): FullyEncryptedKeyedDataFormat
    {
        if (!($this->value instanceof FullyEncryptedKeyedDataFormat && $this->dataFormat === 'fullyEncrypted')) {
            throw new Exception(
                "Expected fullyEncrypted; got " . $this->dataFormat . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPartiallyEncrypted(): bool
    {
        return $this->value instanceof PartiallyEncryptedKeyedDataFormat && $this->dataFormat === 'partiallyEncrypted';
    }

    /**
     * @return PartiallyEncryptedKeyedDataFormat
     */
    public function asPartiallyEncrypted(): PartiallyEncryptedKeyedDataFormat
    {
        if (!($this->value instanceof PartiallyEncryptedKeyedDataFormat && $this->dataFormat === 'partiallyEncrypted')) {
            throw new Exception(
                "Expected partiallyEncrypted; got " . $this->dataFormat . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPlainText(): bool
    {
        return $this->value instanceof PlainTextKeyedDataFormat && $this->dataFormat === 'plainText';
    }

    /**
     * @return PlainTextKeyedDataFormat
     */
    public function asPlainText(): PlainTextKeyedDataFormat
    {
        if (!($this->value instanceof PlainTextKeyedDataFormat && $this->dataFormat === 'plainText')) {
            throw new Exception(
                "Expected plainText; got " . $this->dataFormat . " with value of type " . get_debug_type($this->value),
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
        $result['dataFormat'] = $this->dataFormat;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->dataFormat) {
            case 'fullyEncrypted':
                $value = $this->asFullyEncrypted()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'partiallyEncrypted':
                $value = $this->asPartiallyEncrypted()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'plainText':
                $value = $this->asPlainText()->jsonSerialize();
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
        if (!array_key_exists('dataFormat', $data)) {
            throw new Exception(
                "JSON data is missing property 'dataFormat'",
            );
        }
        $dataFormat = $data['dataFormat'];
        if (!(is_string($dataFormat))) {
            throw new Exception(
                "Expected property 'dataFormat' in JSON data to be string, instead received " . get_debug_type($data['dataFormat']),
            );
        }

        $args['dataFormat'] = $dataFormat;
        switch ($dataFormat) {
            case 'fullyEncrypted':
                $args['value'] = FullyEncryptedKeyedDataFormat::jsonDeserialize($data);
                break;
            case 'partiallyEncrypted':
                $args['value'] = PartiallyEncryptedKeyedDataFormat::jsonDeserialize($data);
                break;
            case 'plainText':
                $args['value'] = PlainTextKeyedDataFormat::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['dataFormat'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
