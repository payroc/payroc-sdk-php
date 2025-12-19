<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about RewardPayChoice.
 */
class RewardPayChoice extends JsonSerializableType
{
    /**
     * @var RewardPayChoiceFees $fees Object that contains information about the fees.
     */
    #[JsonProperty('fees')]
    public RewardPayChoiceFees $fees;

    /**
     * @param array{
     *   fees: RewardPayChoiceFees,
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
