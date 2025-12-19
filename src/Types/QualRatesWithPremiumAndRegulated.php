<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\QualRatesWithPremium;
use Payroc\Core\Json\JsonProperty;

class QualRatesWithPremiumAndRegulated extends JsonSerializableType
{
    use QualRatesWithPremium;

    /**
     * @var ProcessorFee $regulatedCheckCard Object that contains the fees for a regulated debit-card transaction.
     */
    #[JsonProperty('regulatedCheckCard')]
    public ProcessorFee $regulatedCheckCard;

    /**
     * @var ProcessorFee $unregulatedCheckCard Object that contains the fees for an unregulated debit-card transaction.
     */
    #[JsonProperty('unregulatedCheckCard')]
    public ProcessorFee $unregulatedCheckCard;

    /**
     * @param array{
     *   premiumRate: ProcessorFee,
     *   qualifiedRate: ProcessorFee,
     *   midQualRate: ProcessorFee,
     *   nonQualRate: ProcessorFee,
     *   regulatedCheckCard: ProcessorFee,
     *   unregulatedCheckCard: ProcessorFee,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->premiumRate = $values['premiumRate'];
        $this->qualifiedRate = $values['qualifiedRate'];
        $this->midQualRate = $values['midQualRate'];
        $this->nonQualRate = $values['nonQualRate'];
        $this->regulatedCheckCard = $values['regulatedCheckCard'];
        $this->unregulatedCheckCard = $values['unregulatedCheckCard'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
