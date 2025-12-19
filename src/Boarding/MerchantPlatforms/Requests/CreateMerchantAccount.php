<?php

namespace Payroc\Boarding\MerchantPlatforms\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\Business;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\CreateProcessingAccount;
use Payroc\Core\Types\ArrayType;

class CreateMerchantAccount extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var Business $business
     */
    #[JsonProperty('business')]
    public Business $business;

    /**
     * @var array<CreateProcessingAccount> $processingAccounts Array of processingAccounts objects.
     */
    #[JsonProperty('processingAccounts'), ArrayType([CreateProcessingAccount::class])]
    public array $processingAccounts;

    /**
     * @var ?array<string, string> $metadata Object that you can send to include custom data in the request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   business: Business,
     *   processingAccounts: array<CreateProcessingAccount>,
     *   metadata?: ?array<string, string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->business = $values['business'];
        $this->processingAccounts = $values['processingAccounts'];
        $this->metadata = $values['metadata'] ?? null;
    }
}
