<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the tax details.
 */
class Tax extends JsonSerializableType
{
    /**
     * @var (
     *    'amount'
     *   |'rate'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    TaxAmount
     *   |TaxRate
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'amount'
     *   |'rate'
     *   |'_unknown'
     * ),
     *   value: (
     *    TaxAmount
     *   |TaxRate
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
     * @param TaxAmount $amount
     * @return Tax
     */
    public static function amount(TaxAmount $amount): Tax
    {
        return new Tax([
            'type' => 'amount',
            'value' => $amount,
        ]);
    }

    /**
     * @param TaxRate $rate
     * @return Tax
     */
    public static function rate(TaxRate $rate): Tax
    {
        return new Tax([
            'type' => 'rate',
            'value' => $rate,
        ]);
    }

    /**
     * @return bool
     */
    public function isAmount(): bool
    {
        return $this->value instanceof TaxAmount && $this->type === 'amount';
    }

    /**
     * @return TaxAmount
     */
    public function asAmount(): TaxAmount
    {
        if (!($this->value instanceof TaxAmount && $this->type === 'amount')) {
            throw new Exception(
                "Expected amount; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRate(): bool
    {
        return $this->value instanceof TaxRate && $this->type === 'rate';
    }

    /**
     * @return TaxRate
     */
    public function asRate(): TaxRate
    {
        if (!($this->value instanceof TaxRate && $this->type === 'rate')) {
            throw new Exception(
                "Expected rate; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'amount':
                $value = $this->asAmount()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'rate':
                $value = $this->asRate()->jsonSerialize();
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
            case 'amount':
                $args['value'] = TaxAmount::jsonDeserialize($data);
                break;
            case 'rate':
                $args['value'] = TaxRate::jsonDeserialize($data);
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
