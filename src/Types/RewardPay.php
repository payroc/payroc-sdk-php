<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about RewardPay.
 */
class RewardPay extends JsonSerializableType
{
    /**
     * @var RewardPayFees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public RewardPayFees $fees;

    /**
     * @param array{
     *   fees: RewardPayFees,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fees = $values['fees'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
