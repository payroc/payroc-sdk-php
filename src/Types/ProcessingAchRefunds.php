<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the ACH refund policy for the processing account.
 */
class ProcessingAchRefunds extends JsonSerializableType
{
    /**
     * @var bool $writtenRefundPolicy Indicates if the business has a written refund policy.
     */
    #[JsonProperty('writtenRefundPolicy')]
    public bool $writtenRefundPolicy;

    /**
     * @var ?string $refundPolicyUrl URL of the written refund policy.
     */
    #[JsonProperty('refundPolicyUrl')]
    public ?string $refundPolicyUrl;

    /**
     * @param array{
     *   writtenRefundPolicy: bool,
     *   refundPolicyUrl?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->writtenRefundPolicy = $values['writtenRefundPolicy'];
        $this->refundPolicyUrl = $values['refundPolicyUrl'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
