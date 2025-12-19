<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class InterchangePlusTiered3AmexOptBlue extends JsonSerializableType
{
    /**
     * @var ProcessorFee $qualifiedRate Object that contains the fees for a qualified transaction.
     */
    #[JsonProperty('qualifiedRate')]
    public ProcessorFee $qualifiedRate;

    /**
     * @var ProcessorFee $midQualRate Object that contains the fees for a mid-qualified transaction.
     */
    #[JsonProperty('midQualRate')]
    public ProcessorFee $midQualRate;

    /**
     * @var ProcessorFee $nonQualRate Object that contains the fees for a non-qualified transaction.
     */
    #[JsonProperty('nonQualRate')]
    public ProcessorFee $nonQualRate;

    /**
     * @param array{
     *   qualifiedRate: ProcessorFee,
     *   midQualRate: ProcessorFee,
     *   nonQualRate: ProcessorFee,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->qualifiedRate = $values['qualifiedRate'];
        $this->midQualRate = $values['midQualRate'];
        $this->nonQualRate = $values['nonQualRate'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
