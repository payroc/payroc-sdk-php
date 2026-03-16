<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Polymorphic object that contains billing details for Platinum Security.
 *
 * The value of the billingFrequency field determines which variant you should use:
 * -	`monthly` - We collect the fee for Platinum Security each month.
 * -	`annual` - We collect the fee for Platinum Security each year.
 */
class BaseUsPlatinumSecurity extends JsonSerializableType
{
    /**
     * @var (
     *    'monthly'
     *   |'annual'
     *   |'_unknown'
     * ) $billingFrequency
     */
    public readonly string $billingFrequency;

    /**
     * @var (
     *    PlatinumSecurityMonthly
     *   |PlatinumSecurityAnnual
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   billingFrequency: (
     *    'monthly'
     *   |'annual'
     *   |'_unknown'
     * ),
     *   value: (
     *    PlatinumSecurityMonthly
     *   |PlatinumSecurityAnnual
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->billingFrequency = $values['billingFrequency'];
        $this->value = $values['value'];
    }

    /**
     * @param PlatinumSecurityMonthly $monthly
     * @return BaseUsPlatinumSecurity
     */
    public static function monthly(PlatinumSecurityMonthly $monthly): BaseUsPlatinumSecurity
    {
        return new BaseUsPlatinumSecurity([
            'billingFrequency' => 'monthly',
            'value' => $monthly,
        ]);
    }

    /**
     * @param PlatinumSecurityAnnual $annual
     * @return BaseUsPlatinumSecurity
     */
    public static function annual(PlatinumSecurityAnnual $annual): BaseUsPlatinumSecurity
    {
        return new BaseUsPlatinumSecurity([
            'billingFrequency' => 'annual',
            'value' => $annual,
        ]);
    }

    /**
     * @return bool
     */
    public function isMonthly(): bool
    {
        return $this->value instanceof PlatinumSecurityMonthly && $this->billingFrequency === 'monthly';
    }

    /**
     * @return PlatinumSecurityMonthly
     */
    public function asMonthly(): PlatinumSecurityMonthly
    {
        if (!($this->value instanceof PlatinumSecurityMonthly && $this->billingFrequency === 'monthly')) {
            throw new Exception(
                "Expected monthly; got " . $this->billingFrequency . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isAnnual(): bool
    {
        return $this->value instanceof PlatinumSecurityAnnual && $this->billingFrequency === 'annual';
    }

    /**
     * @return PlatinumSecurityAnnual
     */
    public function asAnnual(): PlatinumSecurityAnnual
    {
        if (!($this->value instanceof PlatinumSecurityAnnual && $this->billingFrequency === 'annual')) {
            throw new Exception(
                "Expected annual; got " . $this->billingFrequency . " with value of type " . get_debug_type($this->value),
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
        $result['billingFrequency'] = $this->billingFrequency;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->billingFrequency) {
            case 'monthly':
                $value = $this->asMonthly()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'annual':
                $value = $this->asAnnual()->jsonSerialize();
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
        if (!array_key_exists('billingFrequency', $data)) {
            throw new Exception(
                "JSON data is missing property 'billingFrequency'",
            );
        }
        $billingFrequency = $data['billingFrequency'];
        if (!(is_string($billingFrequency))) {
            throw new Exception(
                "Expected property 'billingFrequency' in JSON data to be string, instead received " . get_debug_type($data['billingFrequency']),
            );
        }

        $args['billingFrequency'] = $billingFrequency;
        switch ($billingFrequency) {
            case 'monthly':
                $args['value'] = PlatinumSecurityMonthly::jsonDeserialize($data);
                break;
            case 'annual':
                $args['value'] = PlatinumSecurityAnnual::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['billingFrequency'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
