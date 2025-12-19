<?php

namespace Payroc\Traits;

use Payroc\Types\ProcessorFee;
use Payroc\Core\Json\JsonProperty;

/**
 * @property ProcessorFee $qualifiedRate
 * @property ProcessorFee $midQualRate
 * @property ProcessorFee $nonQualRate
 */
trait QualRates
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
}
