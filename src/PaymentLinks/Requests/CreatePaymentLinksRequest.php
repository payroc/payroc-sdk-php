<?php

namespace Payroc\PaymentLinks\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\PaymentLinks\Types\CreatePaymentLinksRequestBody;

class CreatePaymentLinksRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var CreatePaymentLinksRequestBody $body
     */
    public CreatePaymentLinksRequestBody $body;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   body: CreatePaymentLinksRequestBody,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->body = $values['body'];
    }
}
