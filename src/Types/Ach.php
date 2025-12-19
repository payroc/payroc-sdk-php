<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the fees for ACH transactions.
 */
class Ach extends JsonSerializableType
{
    /**
     * @var ?AchFees $fees Object that contains processing fees for ACH transactions.
     */
    #[JsonProperty('fees')]
    public ?AchFees $fees;

    /**
     * @param array{
     *   fees?: ?AchFees,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->fees = $values['fees'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
