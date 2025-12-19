<?php

namespace Payroc\CardPayments\Payments\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\OrderAdjustment;
use Payroc\Types\StatusAdjustment;
use Payroc\Types\CustomerAdjustment;
use Payroc\Types\SignatureAdjustment;
use Exception;
use Payroc\Core\Json\JsonDecoder;

class PaymentAdjustmentAdjustmentsItem extends JsonSerializableType
{
    /**
     * @var (
     *    'order'
     *   |'status'
     *   |'customer'
     *   |'signature'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    OrderAdjustment
     *   |StatusAdjustment
     *   |CustomerAdjustment
     *   |SignatureAdjustment
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'order'
     *   |'status'
     *   |'customer'
     *   |'signature'
     *   |'_unknown'
     * ),
     *   value: (
     *    OrderAdjustment
     *   |StatusAdjustment
     *   |CustomerAdjustment
     *   |SignatureAdjustment
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
     * @param OrderAdjustment $order
     * @return PaymentAdjustmentAdjustmentsItem
     */
    public static function order(OrderAdjustment $order): PaymentAdjustmentAdjustmentsItem
    {
        return new PaymentAdjustmentAdjustmentsItem([
            'type' => 'order',
            'value' => $order,
        ]);
    }

    /**
     * @param StatusAdjustment $status
     * @return PaymentAdjustmentAdjustmentsItem
     */
    public static function status(StatusAdjustment $status): PaymentAdjustmentAdjustmentsItem
    {
        return new PaymentAdjustmentAdjustmentsItem([
            'type' => 'status',
            'value' => $status,
        ]);
    }

    /**
     * @param CustomerAdjustment $customer
     * @return PaymentAdjustmentAdjustmentsItem
     */
    public static function customer(CustomerAdjustment $customer): PaymentAdjustmentAdjustmentsItem
    {
        return new PaymentAdjustmentAdjustmentsItem([
            'type' => 'customer',
            'value' => $customer,
        ]);
    }

    /**
     * @param SignatureAdjustment $signature
     * @return PaymentAdjustmentAdjustmentsItem
     */
    public static function signature(SignatureAdjustment $signature): PaymentAdjustmentAdjustmentsItem
    {
        return new PaymentAdjustmentAdjustmentsItem([
            'type' => 'signature',
            'value' => $signature,
        ]);
    }

    /**
     * @return bool
     */
    public function isOrder(): bool
    {
        return $this->value instanceof OrderAdjustment && $this->type === 'order';
    }

    /**
     * @return OrderAdjustment
     */
    public function asOrder(): OrderAdjustment
    {
        if (!($this->value instanceof OrderAdjustment && $this->type === 'order')) {
            throw new Exception(
                "Expected order; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
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
     * @return bool
     */
    public function isSignature(): bool
    {
        return $this->value instanceof SignatureAdjustment && $this->type === 'signature';
    }

    /**
     * @return SignatureAdjustment
     */
    public function asSignature(): SignatureAdjustment
    {
        if (!($this->value instanceof SignatureAdjustment && $this->type === 'signature')) {
            throw new Exception(
                "Expected signature; got " . $this->type . " with value of type " . get_debug_type($this->value),
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
            case 'order':
                $value = $this->asOrder()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'status':
                $value = $this->asStatus()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'customer':
                $value = $this->asCustomer()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'signature':
                $value = $this->asSignature()->jsonSerialize();
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
            case 'order':
                $args['value'] = OrderAdjustment::jsonDeserialize($data);
                break;
            case 'status':
                $args['value'] = StatusAdjustment::jsonDeserialize($data);
                break;
            case 'customer':
                $args['value'] = CustomerAdjustment::jsonDeserialize($data);
                break;
            case 'signature':
                $args['value'] = SignatureAdjustment::jsonDeserialize($data);
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
