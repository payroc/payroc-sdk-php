<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains the single-use token.
 */
class AccountUpdate extends JsonSerializableType
{
    /**
     * @var (
     *    'singleUseToken'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    SingleUseTokenAccountUpdate
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'singleUseToken'
     *   |'_unknown'
     * ),
     *   value: (
     *    SingleUseTokenAccountUpdate
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
     * @param SingleUseTokenAccountUpdate $singleUseToken
     * @return AccountUpdate
     */
    public static function singleUseToken(SingleUseTokenAccountUpdate $singleUseToken): AccountUpdate
    {
        return new AccountUpdate([
            'type' => 'singleUseToken',
            'value' => $singleUseToken,
        ]);
    }

    /**
     * @return bool
     */
    public function isSingleUseToken(): bool
    {
        return $this->value instanceof SingleUseTokenAccountUpdate && $this->type === 'singleUseToken';
    }

    /**
     * @return SingleUseTokenAccountUpdate
     */
    public function asSingleUseToken(): SingleUseTokenAccountUpdate
    {
        if (!($this->value instanceof SingleUseTokenAccountUpdate && $this->type === 'singleUseToken')) {
            throw new Exception(
                "Expected singleUseToken; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'singleUseToken':
                $value = $this->asSingleUseToken()->jsonSerialize();
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
            case 'singleUseToken':
                $args['value'] = SingleUseTokenAccountUpdate::jsonDeserialize($data);
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
