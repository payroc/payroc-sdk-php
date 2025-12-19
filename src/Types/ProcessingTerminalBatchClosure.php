<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about when and how the terminal closes the batch.
 */
class ProcessingTerminalBatchClosure extends JsonSerializableType
{
    /**
     * @var (
     *    'automatic'
     *   |'manual'
     *   |'_unknown'
     * ) $batchCloseType
     */
    public readonly string $batchCloseType;

    /**
     * @var (
     *    SchemasAutomaticBatchClose
     *   |SchemasManualBatchClose
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   batchCloseType: (
     *    'automatic'
     *   |'manual'
     *   |'_unknown'
     * ),
     *   value: (
     *    SchemasAutomaticBatchClose
     *   |SchemasManualBatchClose
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->batchCloseType = $values['batchCloseType'];
        $this->value = $values['value'];
    }

    /**
     * @param SchemasAutomaticBatchClose $automatic
     * @return ProcessingTerminalBatchClosure
     */
    public static function automatic(SchemasAutomaticBatchClose $automatic): ProcessingTerminalBatchClosure
    {
        return new ProcessingTerminalBatchClosure([
            'batchCloseType' => 'automatic',
            'value' => $automatic,
        ]);
    }

    /**
     * @param SchemasManualBatchClose $manual
     * @return ProcessingTerminalBatchClosure
     */
    public static function manual(SchemasManualBatchClose $manual): ProcessingTerminalBatchClosure
    {
        return new ProcessingTerminalBatchClosure([
            'batchCloseType' => 'manual',
            'value' => $manual,
        ]);
    }

    /**
     * @return bool
     */
    public function isAutomatic(): bool
    {
        return $this->value instanceof SchemasAutomaticBatchClose && $this->batchCloseType === 'automatic';
    }

    /**
     * @return SchemasAutomaticBatchClose
     */
    public function asAutomatic(): SchemasAutomaticBatchClose
    {
        if (!($this->value instanceof SchemasAutomaticBatchClose && $this->batchCloseType === 'automatic')) {
            throw new Exception(
                "Expected automatic; got " . $this->batchCloseType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isManual(): bool
    {
        return $this->value instanceof SchemasManualBatchClose && $this->batchCloseType === 'manual';
    }

    /**
     * @return SchemasManualBatchClose
     */
    public function asManual(): SchemasManualBatchClose
    {
        if (!($this->value instanceof SchemasManualBatchClose && $this->batchCloseType === 'manual')) {
            throw new Exception(
                "Expected manual; got " . $this->batchCloseType . " with value of type " . get_debug_type($this->value),
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
        $result['batchCloseType'] = $this->batchCloseType;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->batchCloseType) {
            case 'automatic':
                $value = $this->asAutomatic()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'manual':
                $value = $this->asManual()->jsonSerialize();
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
        if (!array_key_exists('batchCloseType', $data)) {
            throw new Exception(
                "JSON data is missing property 'batchCloseType'",
            );
        }
        $batchCloseType = $data['batchCloseType'];
        if (!(is_string($batchCloseType))) {
            throw new Exception(
                "Expected property 'batchCloseType' in JSON data to be string, instead received " . get_debug_type($data['batchCloseType']),
            );
        }

        $args['batchCloseType'] = $batchCloseType;
        switch ($batchCloseType) {
            case 'automatic':
                $args['value'] = SchemasAutomaticBatchClose::jsonDeserialize($data);
                break;
            case 'manual':
                $args['value'] = SchemasManualBatchClose::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['batchCloseType'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
