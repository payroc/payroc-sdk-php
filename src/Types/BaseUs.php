<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about U.S. base fees.
 */
class BaseUs extends JsonSerializableType
{
    /**
     * @var ?int $addressVerification Fee for each address verification request. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('addressVerification')]
    public ?int $addressVerification;

    /**
     * @var BaseUsAnnualFee $annualFee Object that contains information about the annual fee.
     */
    #[JsonProperty('annualFee')]
    public BaseUsAnnualFee $annualFee;

    /**
     * @var ?int $regulatoryAssistanceProgram Annual fee for the regulatory assistance program. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('regulatoryAssistanceProgram')]
    public ?int $regulatoryAssistanceProgram;

    /**
     * @var ?int $pciNonCompliance Fee that we apply each month if you aren't compliant with PCI standards. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('pciNonCompliance')]
    public ?int $pciNonCompliance;

    /**
     * @var ?int $merchantAdvantage Monthly fee for Payroc Advantage. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('merchantAdvantage')]
    public ?int $merchantAdvantage;

    /**
     * @var ?BaseUsPlatinumSecurity $platinumSecurity Object that contains information about the Platinum Security fee.
     */
    #[JsonProperty('platinumSecurity')]
    public ?BaseUsPlatinumSecurity $platinumSecurity;

    /**
     * @var int $maintenance Monthly fee for maintenance. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('maintenance')]
    public int $maintenance;

    /**
     * @var int $minimum Monthly fee that we charge when the merchant doesn't meet the minimum fee amount. This monthly fee is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('minimum')]
    public int $minimum;

    /**
     * @var ?int $voiceAuthorization Fee for each voice authorization. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('voiceAuthorization')]
    public ?int $voiceAuthorization;

    /**
     * @var ?int $chargeback Fee for each chargeback. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('chargeback')]
    public ?int $chargeback;

    /**
     * @var ?int $retrieval Fee for each retrieval. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('retrieval')]
    public ?int $retrieval;

    /**
     * @var int $batch Fee for each batch. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('batch')]
    public int $batch;

    /**
     * @var ?int $earlyTermination Fee for early termination. The value is in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('earlyTermination')]
    public ?int $earlyTermination;

    /**
     * @param array{
     *   annualFee: BaseUsAnnualFee,
     *   maintenance: int,
     *   minimum: int,
     *   batch: int,
     *   addressVerification?: ?int,
     *   regulatoryAssistanceProgram?: ?int,
     *   pciNonCompliance?: ?int,
     *   merchantAdvantage?: ?int,
     *   platinumSecurity?: ?BaseUsPlatinumSecurity,
     *   voiceAuthorization?: ?int,
     *   chargeback?: ?int,
     *   retrieval?: ?int,
     *   earlyTermination?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->addressVerification = $values['addressVerification'] ?? null;
        $this->annualFee = $values['annualFee'];
        $this->regulatoryAssistanceProgram = $values['regulatoryAssistanceProgram'] ?? null;
        $this->pciNonCompliance = $values['pciNonCompliance'] ?? null;
        $this->merchantAdvantage = $values['merchantAdvantage'] ?? null;
        $this->platinumSecurity = $values['platinumSecurity'] ?? null;
        $this->maintenance = $values['maintenance'];
        $this->minimum = $values['minimum'];
        $this->voiceAuthorization = $values['voiceAuthorization'] ?? null;
        $this->chargeback = $values['chargeback'] ?? null;
        $this->retrieval = $values['retrieval'] ?? null;
        $this->batch = $values['batch'];
        $this->earlyTermination = $values['earlyTermination'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
