<?php

namespace Payroc\BankTransferPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\BankTransferPayments\Payments\Types\RepresentmentPaymentMethod;
use Payroc\Core\Json\JsonProperty;

class Representment extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?RepresentmentPaymentMethod $paymentMethod Object that contains information about the customer's payment details.
     */
    #[JsonProperty('paymentMethod')]
    public ?RepresentmentPaymentMethod $paymentMethod;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   paymentMethod?: ?RepresentmentPaymentMethod,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->paymentMethod = $values['paymentMethod'] ?? null;
    }
}
