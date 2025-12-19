<?php

namespace Payroc\Traits;

use Payroc\Types\ProcessorFee;
use Payroc\Core\Json\JsonProperty;

/**
 * @property ProcessorFee $premiumRate
 */
trait QualRatesWithPremium
{
    use QualRates;

    /**
     * @var ProcessorFee $premiumRate Object that contains the fees for a premium rate transaction.
     */
    #[JsonProperty('premiumRate')]
    public ProcessorFee $premiumRate;
}
