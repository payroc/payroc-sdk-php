<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Indicates whether the merchant or the customer enters the amount for the transaction.
 */
class MultiUsePaymentLinkOrderCharge extends JsonSerializableType
{
    /**
     * @var (
     *    'prompt'
     *   |'preset'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    PromptPaymentLinkCharge
     *   |PresetPaymentLinkCharge
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'prompt'
     *   |'preset'
     *   |'_unknown'
     * ),
     *   value: (
     *    PromptPaymentLinkCharge
     *   |PresetPaymentLinkCharge
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
     * @param PromptPaymentLinkCharge $prompt
     * @return MultiUsePaymentLinkOrderCharge
     */
    public static function prompt(PromptPaymentLinkCharge $prompt): MultiUsePaymentLinkOrderCharge
    {
        return new MultiUsePaymentLinkOrderCharge([
            'type' => 'prompt',
            'value' => $prompt,
        ]);
    }

    /**
     * @param PresetPaymentLinkCharge $preset
     * @return MultiUsePaymentLinkOrderCharge
     */
    public static function preset(PresetPaymentLinkCharge $preset): MultiUsePaymentLinkOrderCharge
    {
        return new MultiUsePaymentLinkOrderCharge([
            'type' => 'preset',
            'value' => $preset,
        ]);
    }

    /**
     * @return bool
     */
    public function isPrompt(): bool
    {
        return $this->value instanceof PromptPaymentLinkCharge && $this->type === 'prompt';
    }

    /**
     * @return PromptPaymentLinkCharge
     */
    public function asPrompt(): PromptPaymentLinkCharge
    {
        if (!($this->value instanceof PromptPaymentLinkCharge && $this->type === 'prompt')) {
            throw new Exception(
                "Expected prompt; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPreset(): bool
    {
        return $this->value instanceof PresetPaymentLinkCharge && $this->type === 'preset';
    }

    /**
     * @return PresetPaymentLinkCharge
     */
    public function asPreset(): PresetPaymentLinkCharge
    {
        if (!($this->value instanceof PresetPaymentLinkCharge && $this->type === 'preset')) {
            throw new Exception(
                "Expected preset; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'prompt':
                $value = $this->asPrompt()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'preset':
                $value = $this->asPreset()->jsonSerialize();
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
            case 'prompt':
                $args['value'] = PromptPaymentLinkCharge::jsonDeserialize($data);
                break;
            case 'preset':
                $args['value'] = PresetPaymentLinkCharge::jsonDeserialize($data);
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
