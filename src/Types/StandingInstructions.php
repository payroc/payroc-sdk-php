<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * If you don't use our Subscriptions mechanism, include this section to configure your standing/recurring orders.
 */
class StandingInstructions extends JsonSerializableType
{
    /**
     * @var value-of<StandingInstructionsSequence> $sequence Position of the transaction in the payment plan sequence.
     */
    #[JsonProperty('sequence')]
    public string $sequence;

    /**
     * Indicates the type of payment instruction.
     *
     * - 'unscheduled' – The payment is not part of a regular billing cycle.
     * - 'recurring' – The payment is part of a regular billing cycle with no end date.
     * - 'installment' – The payment is part of a regular billing cycle with an end date.
     *
     * @var value-of<StandingInstructionsProcessingModel> $processingModel
     */
    #[JsonProperty('processingModel')]
    public string $processingModel;

    /**
     * @var ?FirstTxnReferenceData $referenceDataOfFirstTxn Object that contains information about the initial payment for the payment instruction.
     */
    #[JsonProperty('referenceDataOfFirstTxn')]
    public ?FirstTxnReferenceData $referenceDataOfFirstTxn;

    /**
     * @param array{
     *   sequence: value-of<StandingInstructionsSequence>,
     *   processingModel: value-of<StandingInstructionsProcessingModel>,
     *   referenceDataOfFirstTxn?: ?FirstTxnReferenceData,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->sequence = $values['sequence'];
        $this->processingModel = $values['processingModel'];
        $this->referenceDataOfFirstTxn = $values['referenceDataOfFirstTxn'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
