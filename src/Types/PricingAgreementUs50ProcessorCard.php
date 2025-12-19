<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about card fees.
 */
class PricingAgreementUs50ProcessorCard extends JsonSerializableType
{
    /**
     * @var (
     *    'interchangePlus'
     *   |'interchangePlusPlus'
     *   |'tiered3'
     *   |'tiered4'
     *   |'tiered6'
     *   |'flatRate'
     *   |'consumerChoice'
     *   |'rewardPayChoice'
     *   |'_unknown'
     * ) $planType
     */
    public readonly string $planType;

    /**
     * @var (
     *    InterchangePlus
     *   |InterchangePlusPlus
     *   |Tiered3
     *   |Tiered4
     *   |Tiered6
     *   |FlatRate
     *   |ConsumerChoice
     *   |RewardPayChoice
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   planType: (
     *    'interchangePlus'
     *   |'interchangePlusPlus'
     *   |'tiered3'
     *   |'tiered4'
     *   |'tiered6'
     *   |'flatRate'
     *   |'consumerChoice'
     *   |'rewardPayChoice'
     *   |'_unknown'
     * ),
     *   value: (
     *    InterchangePlus
     *   |InterchangePlusPlus
     *   |Tiered3
     *   |Tiered4
     *   |Tiered6
     *   |FlatRate
     *   |ConsumerChoice
     *   |RewardPayChoice
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->planType = $values['planType'];
        $this->value = $values['value'];
    }

    /**
     * @param InterchangePlus $interchangePlus
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function interchangePlus(InterchangePlus $interchangePlus): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'interchangePlus',
            'value' => $interchangePlus,
        ]);
    }

    /**
     * @param InterchangePlusPlus $interchangePlusPlus
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function interchangePlusPlus(InterchangePlusPlus $interchangePlusPlus): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'interchangePlusPlus',
            'value' => $interchangePlusPlus,
        ]);
    }

    /**
     * @param Tiered3 $tiered3
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function tiered3(Tiered3 $tiered3): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'tiered3',
            'value' => $tiered3,
        ]);
    }

    /**
     * @param Tiered4 $tiered4
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function tiered4(Tiered4 $tiered4): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'tiered4',
            'value' => $tiered4,
        ]);
    }

    /**
     * @param Tiered6 $tiered6
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function tiered6(Tiered6 $tiered6): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'tiered6',
            'value' => $tiered6,
        ]);
    }

    /**
     * @param FlatRate $flatRate
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function flatRate(FlatRate $flatRate): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'flatRate',
            'value' => $flatRate,
        ]);
    }

    /**
     * @param ConsumerChoice $consumerChoice
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function consumerChoice(ConsumerChoice $consumerChoice): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'consumerChoice',
            'value' => $consumerChoice,
        ]);
    }

    /**
     * @param RewardPayChoice $rewardPayChoice
     * @return PricingAgreementUs50ProcessorCard
     */
    public static function rewardPayChoice(RewardPayChoice $rewardPayChoice): PricingAgreementUs50ProcessorCard
    {
        return new PricingAgreementUs50ProcessorCard([
            'planType' => 'rewardPayChoice',
            'value' => $rewardPayChoice,
        ]);
    }

    /**
     * @return bool
     */
    public function isInterchangePlus(): bool
    {
        return $this->value instanceof InterchangePlus && $this->planType === 'interchangePlus';
    }

    /**
     * @return InterchangePlus
     */
    public function asInterchangePlus(): InterchangePlus
    {
        if (!($this->value instanceof InterchangePlus && $this->planType === 'interchangePlus')) {
            throw new Exception(
                "Expected interchangePlus; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isInterchangePlusPlus(): bool
    {
        return $this->value instanceof InterchangePlusPlus && $this->planType === 'interchangePlusPlus';
    }

    /**
     * @return InterchangePlusPlus
     */
    public function asInterchangePlusPlus(): InterchangePlusPlus
    {
        if (!($this->value instanceof InterchangePlusPlus && $this->planType === 'interchangePlusPlus')) {
            throw new Exception(
                "Expected interchangePlusPlus; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isTiered3(): bool
    {
        return $this->value instanceof Tiered3 && $this->planType === 'tiered3';
    }

    /**
     * @return Tiered3
     */
    public function asTiered3(): Tiered3
    {
        if (!($this->value instanceof Tiered3 && $this->planType === 'tiered3')) {
            throw new Exception(
                "Expected tiered3; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isTiered4(): bool
    {
        return $this->value instanceof Tiered4 && $this->planType === 'tiered4';
    }

    /**
     * @return Tiered4
     */
    public function asTiered4(): Tiered4
    {
        if (!($this->value instanceof Tiered4 && $this->planType === 'tiered4')) {
            throw new Exception(
                "Expected tiered4; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isTiered6(): bool
    {
        return $this->value instanceof Tiered6 && $this->planType === 'tiered6';
    }

    /**
     * @return Tiered6
     */
    public function asTiered6(): Tiered6
    {
        if (!($this->value instanceof Tiered6 && $this->planType === 'tiered6')) {
            throw new Exception(
                "Expected tiered6; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isFlatRate(): bool
    {
        return $this->value instanceof FlatRate && $this->planType === 'flatRate';
    }

    /**
     * @return FlatRate
     */
    public function asFlatRate(): FlatRate
    {
        if (!($this->value instanceof FlatRate && $this->planType === 'flatRate')) {
            throw new Exception(
                "Expected flatRate; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isConsumerChoice(): bool
    {
        return $this->value instanceof ConsumerChoice && $this->planType === 'consumerChoice';
    }

    /**
     * @return ConsumerChoice
     */
    public function asConsumerChoice(): ConsumerChoice
    {
        if (!($this->value instanceof ConsumerChoice && $this->planType === 'consumerChoice')) {
            throw new Exception(
                "Expected consumerChoice; got " . $this->planType . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isRewardPayChoice(): bool
    {
        return $this->value instanceof RewardPayChoice && $this->planType === 'rewardPayChoice';
    }

    /**
     * @return RewardPayChoice
     */
    public function asRewardPayChoice(): RewardPayChoice
    {
        if (!($this->value instanceof RewardPayChoice && $this->planType === 'rewardPayChoice')) {
            throw new Exception(
                "Expected rewardPayChoice; got " . $this->planType . " with value of type " . get_debug_type($this->value),
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
        $result['planType'] = $this->planType;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->planType) {
            case 'interchangePlus':
                $value = $this->asInterchangePlus()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'interchangePlusPlus':
                $value = $this->asInterchangePlusPlus()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'tiered3':
                $value = $this->asTiered3()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'tiered4':
                $value = $this->asTiered4()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'tiered6':
                $value = $this->asTiered6()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'flatRate':
                $value = $this->asFlatRate()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'consumerChoice':
                $value = $this->asConsumerChoice()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'rewardPayChoice':
                $value = $this->asRewardPayChoice()->jsonSerialize();
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
        if (!array_key_exists('planType', $data)) {
            throw new Exception(
                "JSON data is missing property 'planType'",
            );
        }
        $planType = $data['planType'];
        if (!(is_string($planType))) {
            throw new Exception(
                "Expected property 'planType' in JSON data to be string, instead received " . get_debug_type($data['planType']),
            );
        }

        $args['planType'] = $planType;
        switch ($planType) {
            case 'interchangePlus':
                $args['value'] = InterchangePlus::jsonDeserialize($data);
                break;
            case 'interchangePlusPlus':
                $args['value'] = InterchangePlusPlus::jsonDeserialize($data);
                break;
            case 'tiered3':
                $args['value'] = Tiered3::jsonDeserialize($data);
                break;
            case 'tiered4':
                $args['value'] = Tiered4::jsonDeserialize($data);
                break;
            case 'tiered6':
                $args['value'] = Tiered6::jsonDeserialize($data);
                break;
            case 'flatRate':
                $args['value'] = FlatRate::jsonDeserialize($data);
                break;
            case 'consumerChoice':
                $args['value'] = ConsumerChoice::jsonDeserialize($data);
                break;
            case 'rewardPayChoice':
                $args['value'] = RewardPayChoice::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['planType'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
