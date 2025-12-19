<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about Automated Clearing House (ACH) transactions.
 */
class ProcessingAch extends JsonSerializableType
{
    /**
     * @var ?string $naics North American Industry Classification System (NAICS) code.
     */
    #[JsonProperty('naics')]
    public ?string $naics;

    /**
     * @var ?bool $previouslyTerminatedForAch Indicates if the business or its principals were previously turned down for ACH processing.
     */
    #[JsonProperty('previouslyTerminatedForAch')]
    public ?bool $previouslyTerminatedForAch;

    /**
     * @var ProcessingAchRefunds $refunds Object that contains information about the ACH refund policy for the processing account.
     */
    #[JsonProperty('refunds')]
    public ProcessingAchRefunds $refunds;

    /**
     * @var int $estimatedMonthlyTransactions Estimated maximum number of transactions that the merchant will process in a month.
     */
    #[JsonProperty('estimatedMonthlyTransactions')]
    public int $estimatedMonthlyTransactions;

    /**
     * @var ProcessingAchLimits $limits Object that contains information about transaction limits for the processing account.
     */
    #[JsonProperty('limits')]
    public ProcessingAchLimits $limits;

    /**
     * @var ?array<value-of<ProcessingAchTransactionTypesItem>> $transactionTypes List of transaction types that the processing account supports.
     */
    #[JsonProperty('transactionTypes'), ArrayType(['string'])]
    public ?array $transactionTypes;

    /**
     * @var ?string $transactionTypesOther If you send a value of `other` for transactionTypes, provide a list of the supported transaction types.
     */
    #[JsonProperty('transactionTypesOther')]
    public ?string $transactionTypesOther;

    /**
     * @param array{
     *   refunds: ProcessingAchRefunds,
     *   estimatedMonthlyTransactions: int,
     *   limits: ProcessingAchLimits,
     *   naics?: ?string,
     *   previouslyTerminatedForAch?: ?bool,
     *   transactionTypes?: ?array<value-of<ProcessingAchTransactionTypesItem>>,
     *   transactionTypesOther?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->naics = $values['naics'] ?? null;
        $this->previouslyTerminatedForAch = $values['previouslyTerminatedForAch'] ?? null;
        $this->refunds = $values['refunds'];
        $this->estimatedMonthlyTransactions = $values['estimatedMonthlyTransactions'];
        $this->limits = $values['limits'];
        $this->transactionTypes = $values['transactionTypes'] ?? null;
        $this->transactionTypesOther = $values['transactionTypesOther'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
