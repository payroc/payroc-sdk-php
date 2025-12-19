<?php

namespace Payroc\PaymentFeatures\Cards\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\CardPayload;
use Payroc\Types\SingleUseTokenPayload;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the card.
 */
class BalanceInquiryCard extends JsonSerializableType
{
    /**
     * @var (
     *    'card'
     *   |'singleUseToken'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    CardPayload
     *   |SingleUseTokenPayload
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'card'
     *   |'singleUseToken'
     *   |'_unknown'
     * ),
     *   value: (
     *    CardPayload
     *   |SingleUseTokenPayload
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
     * @param CardPayload $card
     * @return BalanceInquiryCard
     */
    public static function card(CardPayload $card): BalanceInquiryCard
    {
        return new BalanceInquiryCard([
            'type' => 'card',
            'value' => $card,
        ]);
    }

    /**
     * @param SingleUseTokenPayload $singleUseToken
     * @return BalanceInquiryCard
     */
    public static function singleUseToken(SingleUseTokenPayload $singleUseToken): BalanceInquiryCard
    {
        return new BalanceInquiryCard([
            'type' => 'singleUseToken',
            'value' => $singleUseToken,
        ]);
    }

    /**
     * @return bool
     */
    public function isCard(): bool
    {
        return $this->value instanceof CardPayload && $this->type === 'card';
    }

    /**
     * @return CardPayload
     */
    public function asCard(): CardPayload
    {
        if (!($this->value instanceof CardPayload && $this->type === 'card')) {
            throw new Exception(
                "Expected card; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isSingleUseToken(): bool
    {
        return $this->value instanceof SingleUseTokenPayload && $this->type === 'singleUseToken';
    }

    /**
     * @return SingleUseTokenPayload
     */
    public function asSingleUseToken(): SingleUseTokenPayload
    {
        if (!($this->value instanceof SingleUseTokenPayload && $this->type === 'singleUseToken')) {
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
            case 'card':
                $value = $this->asCard()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
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
            case 'card':
                $args['value'] = CardPayload::jsonDeserialize($data);
                break;
            case 'singleUseToken':
                $args['value'] = SingleUseTokenPayload::jsonDeserialize($data);
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
