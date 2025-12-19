<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the configuration settings for the merchant.
 */
class TsysMerchant extends JsonSerializableType
{
    /**
     * @var string $posMid Unique identifier that the host processor assigned to the merchant.
     */
    #[JsonProperty('posMid')]
    public string $posMid;

    /**
     * @var string $chainNumber Number that represents the merchant's chain of locations or stores.
     */
    #[JsonProperty('chainNumber')]
    public string $chainNumber;

    /**
     * @var ?string $settlementAgent Unique identifier of the merchant's settlement agent.
     */
    #[JsonProperty('settlementAgent')]
    public ?string $settlementAgent;

    /**
     * @var ?string $abaNumber Number that identifies the merchant in direct debit requests.
     */
    #[JsonProperty('abaNumber')]
    public ?string $abaNumber;

    /**
     * @var string $binNumber Unique identifier of the merchant's bank.
     */
    #[JsonProperty('binNumber')]
    public string $binNumber;

    /**
     * @var ?string $agentBankNumber Number of the merchant's bank if it processes transactions on behalf of another entity.
     */
    #[JsonProperty('agentBankNumber')]
    public ?string $agentBankNumber;

    /**
     * @var ?string $reimbursementAttribute Indicates if the merchant can accept interlink debit cards.
     */
    #[JsonProperty('reimbursementAttribute')]
    public ?string $reimbursementAttribute;

    /**
     * @var ?string $locationNumber Location of the merchant's information.
     */
    #[JsonProperty('locationNumber')]
    public ?string $locationNumber;

    /**
     * @param array{
     *   posMid: string,
     *   chainNumber: string,
     *   binNumber: string,
     *   settlementAgent?: ?string,
     *   abaNumber?: ?string,
     *   agentBankNumber?: ?string,
     *   reimbursementAttribute?: ?string,
     *   locationNumber?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->posMid = $values['posMid'];
        $this->chainNumber = $values['chainNumber'];
        $this->settlementAgent = $values['settlementAgent'] ?? null;
        $this->abaNumber = $values['abaNumber'] ?? null;
        $this->binNumber = $values['binNumber'];
        $this->agentBankNumber = $values['agentBankNumber'] ?? null;
        $this->reimbursementAttribute = $values['reimbursementAttribute'] ?? null;
        $this->locationNumber = $values['locationNumber'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
