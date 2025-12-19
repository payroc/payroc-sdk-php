<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class SwipedCardDetailsSwipedData extends JsonSerializableType
{
    /**
     * @var (
     *    'encrypted'
     *   |'plainText'
     *   |'_unknown'
     * ) $dataFormat
     */
    public readonly string $dataFormat;

    /**
     * @var (
     *    EncryptedSwipedDataFormat
     *   |PlainTextSwipedDataFormat
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   dataFormat: (
     *    'encrypted'
     *   |'plainText'
     *   |'_unknown'
     * ),
     *   value: (
     *    EncryptedSwipedDataFormat
     *   |PlainTextSwipedDataFormat
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
     * @param EncryptedSwipedDataFormat $encrypted
     * @return SwipedCardDetailsSwipedData
     */
    public static function encrypted(EncryptedSwipedDataFormat $encrypted): SwipedCardDetailsSwipedData
    {
        return new SwipedCardDetailsSwipedData([
            'dataFormat' => 'encrypted',
            'value' => $encrypted,
        ]);
    }

    /**
     * @param PlainTextSwipedDataFormat $plainText
     * @return SwipedCardDetailsSwipedData
     */
    public static function plainText(PlainTextSwipedDataFormat $plainText): SwipedCardDetailsSwipedData
    {
        return new SwipedCardDetailsSwipedData([
            'dataFormat' => 'plainText',
            'value' => $plainText,
        ]);
    }

    /**
     * @return bool
     */
    public function isEncrypted(): bool
    {
        return $this->value instanceof EncryptedSwipedDataFormat && $this->dataFormat === 'encrypted';
    }

    /**
     * @return EncryptedSwipedDataFormat
     */
    public function asEncrypted(): EncryptedSwipedDataFormat
    {
        if (!($this->value instanceof EncryptedSwipedDataFormat && $this->dataFormat === 'encrypted')) {
            throw new Exception(
                "Expected encrypted; got " . $this->dataFormat . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPlainText(): bool
    {
        return $this->value instanceof PlainTextSwipedDataFormat && $this->dataFormat === 'plainText';
    }

    /**
     * @return PlainTextSwipedDataFormat
     */
    public function asPlainText(): PlainTextSwipedDataFormat
    {
        if (!($this->value instanceof PlainTextSwipedDataFormat && $this->dataFormat === 'plainText')) {
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
            case 'encrypted':
                $value = $this->asEncrypted()->jsonSerialize();
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
            case 'encrypted':
                $args['value'] = EncryptedSwipedDataFormat::jsonDeserialize($data);
                break;
            case 'plainText':
                $args['value'] = PlainTextSwipedDataFormat::jsonDeserialize($data);
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
