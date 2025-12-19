<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the 3-D Secure information from a third party.
 */
class ThirdPartyThreeDSecure extends JsonSerializableType
{
    /**
     * @var value-of<ThirdPartyThreeDSecureEci> $eci E-commerce indicator (ECI) result of a the 3-D Secure check.
     */
    #[JsonProperty('eci')]
    public string $eci;

    /**
     * @var ?string $xid Unique transaction identifier that the merchant assigned to the transaction and sent in the authentication request.
     */
    #[JsonProperty('xid')]
    public ?string $xid;

    /**
     * @var ?string $cavv Cardholder Authentication Verification Value (CAVV) that the card issuer provided to prove that they authorized the online payment.
     */
    #[JsonProperty('cavv')]
    public ?string $cavv;

    /**
     * @var ?string $dsTransactionId Directory Server Transaction ID that the processor assigned to the request.
     */
    #[JsonProperty('dsTransactionId')]
    public ?string $dsTransactionId;

    /**
     * @param array{
     *   eci: value-of<ThirdPartyThreeDSecureEci>,
     *   xid?: ?string,
     *   cavv?: ?string,
     *   dsTransactionId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->eci = $values['eci'];
        $this->xid = $values['xid'] ?? null;
        $this->cavv = $values['cavv'] ?? null;
        $this->dsTransactionId = $values['dsTransactionId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
