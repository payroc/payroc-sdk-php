<?php

namespace Payroc\PaymentLinks\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\MultiUsePaymentLink;
use Payroc\Types\SingleUsePaymentLink;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class CreatePaymentLinksRequestBody extends JsonSerializableType
{
    /**
     * @var (
     *    'multiUse'
     *   |'singleUse'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    MultiUsePaymentLink
     *   |SingleUsePaymentLink
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'multiUse'
     *   |'singleUse'
     *   |'_unknown'
     * ),
     *   value: (
     *    MultiUsePaymentLink
     *   |SingleUsePaymentLink
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
     * @param MultiUsePaymentLink $multiUse
     * @return CreatePaymentLinksRequestBody
     */
    public static function multiUse(MultiUsePaymentLink $multiUse): CreatePaymentLinksRequestBody
    {
        return new CreatePaymentLinksRequestBody([
            'type' => 'multiUse',
            'value' => $multiUse,
        ]);
    }

    /**
     * @param SingleUsePaymentLink $singleUse
     * @return CreatePaymentLinksRequestBody
     */
    public static function singleUse(SingleUsePaymentLink $singleUse): CreatePaymentLinksRequestBody
    {
        return new CreatePaymentLinksRequestBody([
            'type' => 'singleUse',
            'value' => $singleUse,
        ]);
    }

    /**
     * @return bool
     */
    public function isMultiUse(): bool
    {
        return $this->value instanceof MultiUsePaymentLink && $this->type === 'multiUse';
    }

    /**
     * @return MultiUsePaymentLink
     */
    public function asMultiUse(): MultiUsePaymentLink
    {
        if (!($this->value instanceof MultiUsePaymentLink && $this->type === 'multiUse')) {
            throw new Exception(
                "Expected multiUse; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isSingleUse(): bool
    {
        return $this->value instanceof SingleUsePaymentLink && $this->type === 'singleUse';
    }

    /**
     * @return SingleUsePaymentLink
     */
    public function asSingleUse(): SingleUsePaymentLink
    {
        if (!($this->value instanceof SingleUsePaymentLink && $this->type === 'singleUse')) {
            throw new Exception(
                "Expected singleUse; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'multiUse':
                $value = $this->asMultiUse()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'singleUse':
                $value = $this->asSingleUse()->jsonSerialize();
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
            case 'multiUse':
                $args['value'] = MultiUsePaymentLink::jsonDeserialize($data);
                break;
            case 'singleUse':
                $args['value'] = SingleUsePaymentLink::jsonDeserialize($data);
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
