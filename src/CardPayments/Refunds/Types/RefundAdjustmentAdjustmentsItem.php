<?php

namespace Payroc\CardPayments\Refunds\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\StatusAdjustment;
use Payroc\Types\CustomerAdjustment;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class RefundAdjustmentAdjustmentsItem extends JsonSerializableType
{
    /**
     * @var (
     *    'status'
     *   |'customer'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    StatusAdjustment
     *   |CustomerAdjustment
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'status'
     *   |'customer'
     *   |'_unknown'
     * ),
     *   value: (
     *    StatusAdjustment
     *   |CustomerAdjustment
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
     * @param StatusAdjustment $status
     * @return RefundAdjustmentAdjustmentsItem
     */
    public static function status(StatusAdjustment $status): RefundAdjustmentAdjustmentsItem
    {
        return new RefundAdjustmentAdjustmentsItem([
            'type' => 'status',
            'value' => $status,
        ]);
    }

    /**
     * @param CustomerAdjustment $customer
     * @return RefundAdjustmentAdjustmentsItem
     */
    public static function customer(CustomerAdjustment $customer): RefundAdjustmentAdjustmentsItem
    {
        return new RefundAdjustmentAdjustmentsItem([
            'type' => 'customer',
            'value' => $customer,
        ]);
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->value instanceof StatusAdjustment && $this->type === 'status';
    }

    /**
     * @return StatusAdjustment
     */
    public function asStatus(): StatusAdjustment
    {
        if (!($this->value instanceof StatusAdjustment && $this->type === 'status')) {
            throw new Exception(
                "Expected status; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->value instanceof CustomerAdjustment && $this->type === 'customer';
    }

    /**
     * @return CustomerAdjustment
     */
    public function asCustomer(): CustomerAdjustment
    {
        if (!($this->value instanceof CustomerAdjustment && $this->type === 'customer')) {
            throw new Exception(
                "Expected customer; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'status':
                $value = $this->asStatus()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'customer':
                $value = $this->asCustomer()->jsonSerialize();
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
            case 'status':
                $args['value'] = StatusAdjustment::jsonDeserialize($data);
                break;
            case 'customer':
                $args['value'] = CustomerAdjustment::jsonDeserialize($data);
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
