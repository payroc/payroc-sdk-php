<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\QualRates;
use Payroc\Core\Json\JsonProperty;

class QualRatesWithPremium extends JsonSerializableType
{
    use QualRates;

    /**
     * @var ProcessorFee $premiumRate Object that contains the fees for a premium rate transaction.
     */
    #[JsonProperty('premiumRate')]
    public ProcessorFee $premiumRate;

    /**
     * @param array{
     *   qualifiedRate: ProcessorFee,
     *   midQualRate: ProcessorFee,
     *   nonQualRate: ProcessorFee,
     *   premiumRate: ProcessorFee,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->qualifiedRate = $values['qualifiedRate'];
        $this->midQualRate = $values['midQualRate'];
        $this->nonQualRate = $values['nonQualRate'];
        $this->premiumRate = $values['premiumRate'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
