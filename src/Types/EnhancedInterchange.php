<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the fees for enhanced interchange services.
 */
class EnhancedInterchange extends JsonSerializableType
{
    /**
     * @var int $enrollment Enrollment fee for the enhanced interchange services. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('enrollment')]
    public int $enrollment;

    /**
     * @var float $creditToMerchant Percentage of additional discount.
     */
    #[JsonProperty('creditToMerchant')]
    public float $creditToMerchant;

    /**
     * @param array{
     *   enrollment: int,
     *   creditToMerchant: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->enrollment = $values['enrollment'];
        $this->creditToMerchant = $values['creditToMerchant'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
