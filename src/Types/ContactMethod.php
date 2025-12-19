<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class ContactMethod extends JsonSerializableType
{
    /**
     * @var (
     *    'email'
     *   |'phone'
     *   |'mobile'
     *   |'fax'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    ContactMethodEmail
     *   |ContactMethodPhone
     *   |ContactMethodMobile
     *   |ContactMethodFax
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'email'
     *   |'phone'
     *   |'mobile'
     *   |'fax'
     *   |'_unknown'
     * ),
     *   value: (
     *    ContactMethodEmail
     *   |ContactMethodPhone
     *   |ContactMethodMobile
     *   |ContactMethodFax
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
     * @param ContactMethodEmail $email
     * @return ContactMethod
     */
    public static function email(ContactMethodEmail $email): ContactMethod
    {
        return new ContactMethod([
            'type' => 'email',
            'value' => $email,
        ]);
    }

    /**
     * @param ContactMethodPhone $phone
     * @return ContactMethod
     */
    public static function phone(ContactMethodPhone $phone): ContactMethod
    {
        return new ContactMethod([
            'type' => 'phone',
            'value' => $phone,
        ]);
    }

    /**
     * @param ContactMethodMobile $mobile
     * @return ContactMethod
     */
    public static function mobile(ContactMethodMobile $mobile): ContactMethod
    {
        return new ContactMethod([
            'type' => 'mobile',
            'value' => $mobile,
        ]);
    }

    /**
     * @param ContactMethodFax $fax
     * @return ContactMethod
     */
    public static function fax(ContactMethodFax $fax): ContactMethod
    {
        return new ContactMethod([
            'type' => 'fax',
            'value' => $fax,
        ]);
    }

    /**
     * @return bool
     */
    public function isEmail(): bool
    {
        return $this->value instanceof ContactMethodEmail && $this->type === 'email';
    }

    /**
     * @return ContactMethodEmail
     */
    public function asEmail(): ContactMethodEmail
    {
        if (!($this->value instanceof ContactMethodEmail && $this->type === 'email')) {
            throw new Exception(
                "Expected email; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPhone(): bool
    {
        return $this->value instanceof ContactMethodPhone && $this->type === 'phone';
    }

    /**
     * @return ContactMethodPhone
     */
    public function asPhone(): ContactMethodPhone
    {
        if (!($this->value instanceof ContactMethodPhone && $this->type === 'phone')) {
            throw new Exception(
                "Expected phone; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->value instanceof ContactMethodMobile && $this->type === 'mobile';
    }

    /**
     * @return ContactMethodMobile
     */
    public function asMobile(): ContactMethodMobile
    {
        if (!($this->value instanceof ContactMethodMobile && $this->type === 'mobile')) {
            throw new Exception(
                "Expected mobile; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isFax(): bool
    {
        return $this->value instanceof ContactMethodFax && $this->type === 'fax';
    }

    /**
     * @return ContactMethodFax
     */
    public function asFax(): ContactMethodFax
    {
        if (!($this->value instanceof ContactMethodFax && $this->type === 'fax')) {
            throw new Exception(
                "Expected fax; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'email':
                $value = $this->asEmail()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'phone':
                $value = $this->asPhone()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'mobile':
                $value = $this->asMobile()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'fax':
                $value = $this->asFax()->jsonSerialize();
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
            case 'email':
                $args['value'] = ContactMethodEmail::jsonDeserialize($data);
                break;
            case 'phone':
                $args['value'] = ContactMethodPhone::jsonDeserialize($data);
                break;
            case 'mobile':
                $args['value'] = ContactMethodMobile::jsonDeserialize($data);
                break;
            case 'fax':
                $args['value'] = ContactMethodFax::jsonDeserialize($data);
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
