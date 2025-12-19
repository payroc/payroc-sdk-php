<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that includes information about how we captured the owner's signature.
 */
class Signature extends JsonSerializableType
{
    /**
     * @var (
     *    'requestedViaDirectLink'
     *   |'requestedViaEmail'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    SignatureByDirectLink
     *   |SignatureByEmail
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'requestedViaDirectLink'
     *   |'requestedViaEmail'
     *   |'_unknown'
     * ),
     *   value: (
     *    SignatureByDirectLink
     *   |SignatureByEmail
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
     * @param SignatureByDirectLink $requestedViaDirectLink
     * @return Signature
     */
    public static function requestedViaDirectLink(SignatureByDirectLink $requestedViaDirectLink): Signature
    {
        return new Signature([
            'type' => 'requestedViaDirectLink',
            'value' => $requestedViaDirectLink,
        ]);
    }

    /**
     * @param SignatureByEmail $requestedViaEmail
     * @return Signature
     */
    public static function requestedViaEmail(SignatureByEmail $requestedViaEmail): Signature
    {
        return new Signature([
            'type' => 'requestedViaEmail',
            'value' => $requestedViaEmail,
        ]);
    }

    /**
     * @return bool
     */
    public function isRequestedViaDirectLink(): bool
    {
        return $this->value instanceof SignatureByDirectLink && $this->type === 'requestedViaDirectLink';
    }

    /**
     * @return SignatureByDirectLink
     */
    public function asRequestedViaDirectLink(): SignatureByDirectLink
    {
        if (!($this->value instanceof SignatureByDirectLink && $this->type === 'requestedViaDirectLink')) {
            throw new Exception(
                "Expected requestedViaDirectLink; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRequestedViaEmail(): bool
    {
        return $this->value instanceof SignatureByEmail && $this->type === 'requestedViaEmail';
    }

    /**
     * @return SignatureByEmail
     */
    public function asRequestedViaEmail(): SignatureByEmail
    {
        if (!($this->value instanceof SignatureByEmail && $this->type === 'requestedViaEmail')) {
            throw new Exception(
                "Expected requestedViaEmail; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'requestedViaDirectLink':
                $value = $this->asRequestedViaDirectLink()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'requestedViaEmail':
                $value = $this->asRequestedViaEmail()->jsonSerialize();
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
            case 'requestedViaDirectLink':
                $args['value'] = SignatureByDirectLink::jsonDeserialize($data);
                break;
            case 'requestedViaEmail':
                $args['value'] = SignatureByEmail::jsonDeserialize($data);
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
