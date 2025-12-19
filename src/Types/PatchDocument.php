<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * A JSON Patch operation as defined by RFC 6902.
 */
class PatchDocument extends JsonSerializableType
{
    /**
     * @var (
     *    'add'
     *   |'remove'
     *   |'replace'
     *   |'move'
     *   |'copy'
     *   |'test'
     *   |'_unknown'
     * ) $op
     */
    public readonly string $op;

    /**
     * @var (
     *    PatchAdd
     *   |PatchRemove
     *   |PatchReplace
     *   |PatchMove
     *   |PatchCopy
     *   |PatchTest
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   op: (
     *    'add'
     *   |'remove'
     *   |'replace'
     *   |'move'
     *   |'copy'
     *   |'test'
     *   |'_unknown'
     * ),
     *   value: (
     *    PatchAdd
     *   |PatchRemove
     *   |PatchReplace
     *   |PatchMove
     *   |PatchCopy
     *   |PatchTest
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->op = $values['op'];
        $this->value = $values['value'];
    }

    /**
     * @param PatchAdd $add
     * @return PatchDocument
     */
    public static function add(PatchAdd $add): PatchDocument
    {
        return new PatchDocument([
            'op' => 'add',
            'value' => $add,
        ]);
    }

    /**
     * @param PatchRemove $remove
     * @return PatchDocument
     */
    public static function remove(PatchRemove $remove): PatchDocument
    {
        return new PatchDocument([
            'op' => 'remove',
            'value' => $remove,
        ]);
    }

    /**
     * @param PatchReplace $replace
     * @return PatchDocument
     */
    public static function replace(PatchReplace $replace): PatchDocument
    {
        return new PatchDocument([
            'op' => 'replace',
            'value' => $replace,
        ]);
    }

    /**
     * @param PatchMove $move
     * @return PatchDocument
     */
    public static function move(PatchMove $move): PatchDocument
    {
        return new PatchDocument([
            'op' => 'move',
            'value' => $move,
        ]);
    }

    /**
     * @param PatchCopy $copy
     * @return PatchDocument
     */
    public static function copy(PatchCopy $copy): PatchDocument
    {
        return new PatchDocument([
            'op' => 'copy',
            'value' => $copy,
        ]);
    }

    /**
     * @param PatchTest $test
     * @return PatchDocument
     */
    public static function test(PatchTest $test): PatchDocument
    {
        return new PatchDocument([
            'op' => 'test',
            'value' => $test,
        ]);
    }

    /**
     * @return bool
     */
    public function isAdd(): bool
    {
        return $this->value instanceof PatchAdd && $this->op === 'add';
    }

    /**
     * @return PatchAdd
     */
    public function asAdd(): PatchAdd
    {
        if (!($this->value instanceof PatchAdd && $this->op === 'add')) {
            throw new Exception(
                "Expected add; got " . $this->op . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRemove(): bool
    {
        return $this->value instanceof PatchRemove && $this->op === 'remove';
    }

    /**
     * @return PatchRemove
     */
    public function asRemove(): PatchRemove
    {
        if (!($this->value instanceof PatchRemove && $this->op === 'remove')) {
            throw new Exception(
                "Expected remove; got " . $this->op . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isReplace(): bool
    {
        return $this->value instanceof PatchReplace && $this->op === 'replace';
    }

    /**
     * @return PatchReplace
     */
    public function asReplace(): PatchReplace
    {
        if (!($this->value instanceof PatchReplace && $this->op === 'replace')) {
            throw new Exception(
                "Expected replace; got " . $this->op . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isMove(): bool
    {
        return $this->value instanceof PatchMove && $this->op === 'move';
    }

    /**
     * @return PatchMove
     */
    public function asMove(): PatchMove
    {
        if (!($this->value instanceof PatchMove && $this->op === 'move')) {
            throw new Exception(
                "Expected move; got " . $this->op . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isCopy(): bool
    {
        return $this->value instanceof PatchCopy && $this->op === 'copy';
    }

    /**
     * @return PatchCopy
     */
    public function asCopy(): PatchCopy
    {
        if (!($this->value instanceof PatchCopy && $this->op === 'copy')) {
            throw new Exception(
                "Expected copy; got " . $this->op . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->value instanceof PatchTest && $this->op === 'test';
    }

    /**
     * @return PatchTest
     */
    public function asTest(): PatchTest
    {
        if (!($this->value instanceof PatchTest && $this->op === 'test')) {
            throw new Exception(
                "Expected test; got " . $this->op . " with value of type " . get_debug_type($this->value),
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
        $result['op'] = $this->op;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->op) {
            case 'add':
                $value = $this->asAdd()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'remove':
                $value = $this->asRemove()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'replace':
                $value = $this->asReplace()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'move':
                $value = $this->asMove()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'copy':
                $value = $this->asCopy()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'test':
                $value = $this->asTest()->jsonSerialize();
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
        if (!array_key_exists('op', $data)) {
            throw new Exception(
                "JSON data is missing property 'op'",
            );
        }
        $op = $data['op'];
        if (!(is_string($op))) {
            throw new Exception(
                "Expected property 'op' in JSON data to be string, instead received " . get_debug_type($data['op']),
            );
        }

        $args['op'] = $op;
        switch ($op) {
            case 'add':
                $args['value'] = PatchAdd::jsonDeserialize($data);
                break;
            case 'remove':
                $args['value'] = PatchRemove::jsonDeserialize($data);
                break;
            case 'replace':
                $args['value'] = PatchReplace::jsonDeserialize($data);
                break;
            case 'move':
                $args['value'] = PatchMove::jsonDeserialize($data);
                break;
            case 'copy':
                $args['value'] = PatchCopy::jsonDeserialize($data);
                break;
            case 'test':
                $args['value'] = PatchTest::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['op'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
