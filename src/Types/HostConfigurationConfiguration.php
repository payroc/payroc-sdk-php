<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains the host processor configuration.
 */
class HostConfigurationConfiguration extends JsonSerializableType
{
    /**
     * @var (
     *    'tsys'
     *   |'_unknown'
     * ) $processor
     */
    public readonly string $processor;

    /**
     * @var (
     *    Tsys
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   processor: (
     *    'tsys'
     *   |'_unknown'
     * ),
     *   value: (
     *    Tsys
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->processor = $values['processor'];
        $this->value = $values['value'];
    }

    /**
     * @param Tsys $tsys
     * @return HostConfigurationConfiguration
     */
    public static function tsys(Tsys $tsys): HostConfigurationConfiguration
    {
        return new HostConfigurationConfiguration([
            'processor' => 'tsys',
            'value' => $tsys,
        ]);
    }

    /**
     * @return bool
     */
    public function isTsys(): bool
    {
        return $this->value instanceof Tsys && $this->processor === 'tsys';
    }

    /**
     * @return Tsys
     */
    public function asTsys(): Tsys
    {
        if (!($this->value instanceof Tsys && $this->processor === 'tsys')) {
            throw new Exception(
                "Expected tsys; got " . $this->processor . " with value of type " . get_debug_type($this->value),
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
        $result['processor'] = $this->processor;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->processor) {
            case 'tsys':
                $value = $this->asTsys()->jsonSerialize();
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
        if (!array_key_exists('processor', $data)) {
            throw new Exception(
                "JSON data is missing property 'processor'",
            );
        }
        $processor = $data['processor'];
        if (!(is_string($processor))) {
            throw new Exception(
                "Expected property 'processor' in JSON data to be string, instead received " . get_debug_type($data['processor']),
            );
        }

        $args['processor'] = $processor;
        switch ($processor) {
            case 'tsys':
                $args['value'] = Tsys::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['processor'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
