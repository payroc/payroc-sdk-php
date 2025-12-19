<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class KeyedCardDetailsPinDetails extends JsonSerializableType
{
    /**
     * @var (
     *    'dukpt'
     *   |'_unknown'
     * ) $dataFormat
     */
    public readonly string $dataFormat;

    /**
     * @var (
     *    DukptPinDetails
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   dataFormat: (
     *    'dukpt'
     *   |'_unknown'
     * ),
     *   value: (
     *    DukptPinDetails
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
     * @param DukptPinDetails $dukpt
     * @return KeyedCardDetailsPinDetails
     */
    public static function dukpt(DukptPinDetails $dukpt): KeyedCardDetailsPinDetails
    {
        return new KeyedCardDetailsPinDetails([
            'dataFormat' => 'dukpt',
            'value' => $dukpt,
        ]);
    }

    /**
     * @return bool
     */
    public function isDukpt(): bool
    {
        return $this->value instanceof DukptPinDetails && $this->dataFormat === 'dukpt';
    }

    /**
     * @return DukptPinDetails
     */
    public function asDukpt(): DukptPinDetails
    {
        if (!($this->value instanceof DukptPinDetails && $this->dataFormat === 'dukpt')) {
            throw new Exception(
                "Expected dukpt; got " . $this->dataFormat . " with value of type " . get_debug_type($this->value),
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
            case 'dukpt':
                $value = $this->asDukpt()->jsonSerialize();
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
            case 'dukpt':
                $args['value'] = DukptPinDetails::jsonDeserialize($data);
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
