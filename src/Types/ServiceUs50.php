<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the Hardware Advantage Plan.
 */
class ServiceUs50 extends JsonSerializableType
{
    /**
     * @var (
     *    'hardwareAdvantagePlan'
     *   |'_unknown'
     * ) $name
     */
    public readonly string $name;

    /**
     * @var (
     *    HardwareAdvantagePlan
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   name: (
     *    'hardwareAdvantagePlan'
     *   |'_unknown'
     * ),
     *   value: (
     *    HardwareAdvantagePlan
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
        $this->value = $values['value'];
    }

    /**
     * @param HardwareAdvantagePlan $hardwareAdvantagePlan
     * @return ServiceUs50
     */
    public static function hardwareAdvantagePlan(HardwareAdvantagePlan $hardwareAdvantagePlan): ServiceUs50
    {
        return new ServiceUs50([
            'name' => 'hardwareAdvantagePlan',
            'value' => $hardwareAdvantagePlan,
        ]);
    }

    /**
     * @return bool
     */
    public function isHardwareAdvantagePlan(): bool
    {
        return $this->value instanceof HardwareAdvantagePlan && $this->name === 'hardwareAdvantagePlan';
    }

    /**
     * @return HardwareAdvantagePlan
     */
    public function asHardwareAdvantagePlan(): HardwareAdvantagePlan
    {
        if (!($this->value instanceof HardwareAdvantagePlan && $this->name === 'hardwareAdvantagePlan')) {
            throw new Exception(
                "Expected hardwareAdvantagePlan; got " . $this->name . " with value of type " . get_debug_type($this->value),
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
        $result['name'] = $this->name;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->name) {
            case 'hardwareAdvantagePlan':
                $value = $this->asHardwareAdvantagePlan()->jsonSerialize();
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
        if (!array_key_exists('name', $data)) {
            throw new Exception(
                "JSON data is missing property 'name'",
            );
        }
        $name = $data['name'];
        if (!(is_string($name))) {
            throw new Exception(
                "Expected property 'name' in JSON data to be string, instead received " . get_debug_type($data['name']),
            );
        }

        $args['name'] = $name;
        switch ($name) {
            case 'hardwareAdvantagePlan':
                $args['value'] = HardwareAdvantagePlan::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['name'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
