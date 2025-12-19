<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Exception;
use Payroc\Core\Json\JsonDecoder;

/**
 * Object that contains information about the bank account.
 */
class BankTransferPaymentBankAccount extends JsonSerializableType
{
    /**
     * @var (
     *    'ach'
     *   |'pad'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    AchBankAccount
     *   |PadBankAccount
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'ach'
     *   |'pad'
     *   |'_unknown'
     * ),
     *   value: (
     *    AchBankAccount
     *   |PadBankAccount
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
     * @param AchBankAccount $ach
     * @return BankTransferPaymentBankAccount
     */
    public static function ach(AchBankAccount $ach): BankTransferPaymentBankAccount
    {
        return new BankTransferPaymentBankAccount([
            'type' => 'ach',
            'value' => $ach,
        ]);
    }

    /**
     * @param PadBankAccount $pad
     * @return BankTransferPaymentBankAccount
     */
    public static function pad(PadBankAccount $pad): BankTransferPaymentBankAccount
    {
        return new BankTransferPaymentBankAccount([
            'type' => 'pad',
            'value' => $pad,
        ]);
    }

    /**
     * @return bool
     */
    public function isAch(): bool
    {
        return $this->value instanceof AchBankAccount && $this->type === 'ach';
    }

    /**
     * @return AchBankAccount
     */
    public function asAch(): AchBankAccount
    {
        if (!($this->value instanceof AchBankAccount && $this->type === 'ach')) {
            throw new Exception(
                "Expected ach; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPad(): bool
    {
        return $this->value instanceof PadBankAccount && $this->type === 'pad';
    }

    /**
     * @return PadBankAccount
     */
    public function asPad(): PadBankAccount
    {
        if (!($this->value instanceof PadBankAccount && $this->type === 'pad')) {
            throw new Exception(
                "Expected pad; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'ach':
                $value = $this->asAch()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'pad':
                $value = $this->asPad()->jsonSerialize();
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
            case 'ach':
                $args['value'] = AchBankAccount::jsonDeserialize($data);
                break;
            case 'pad':
                $args['value'] = PadBankAccount::jsonDeserialize($data);
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
