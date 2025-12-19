<?php

namespace Payroc\Boarding\ProcessingAccounts\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\PricingAgreementReminder;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class CreateReminderProcessingAccountsRequestBody extends JsonSerializableType
{
    /**
     * @var (
     *    'pricingAgreement'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    PricingAgreementReminder
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'pricingAgreement'
     *   |'_unknown'
     * ),
     *   value: (
     *    PricingAgreementReminder
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
     * @param PricingAgreementReminder $pricingAgreement
     * @return CreateReminderProcessingAccountsRequestBody
     */
    public static function pricingAgreement(PricingAgreementReminder $pricingAgreement): CreateReminderProcessingAccountsRequestBody
    {
        return new CreateReminderProcessingAccountsRequestBody([
            'type' => 'pricingAgreement',
            'value' => $pricingAgreement,
        ]);
    }

    /**
     * @return bool
     */
    public function isPricingAgreement(): bool
    {
        return $this->value instanceof PricingAgreementReminder && $this->type === 'pricingAgreement';
    }

    /**
     * @return PricingAgreementReminder
     */
    public function asPricingAgreement(): PricingAgreementReminder
    {
        if (!($this->value instanceof PricingAgreementReminder && $this->type === 'pricingAgreement')) {
            throw new Exception(
                "Expected pricingAgreement; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'pricingAgreement':
                $value = $this->asPricingAgreement()->jsonSerialize();
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
            case 'pricingAgreement':
                $args['value'] = PricingAgreementReminder::jsonDeserialize($data);
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
