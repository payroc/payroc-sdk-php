<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\BaseIntent;
use Payroc\Traits\PricingAgreementUs50;
use DateTime;

/**
 * Object that contains information about a pricing intent for Merchant Processing Agreement (MPA) 5.0.
 */
class PricingIntent50 extends JsonSerializableType
{
    use BaseIntent;
    use PricingAgreementUs50;


    /**
     * @param array{
     *   key: string,
     *   country: value-of<PricingAgreementUs50Country>,
     *   version: value-of<PricingAgreementUs50Version>,
     *   base: BaseUs,
     *   id?: ?string,
     *   createdDate?: ?DateTime,
     *   lastUpdatedDate?: ?DateTime,
     *   status?: ?value-of<BaseIntentStatus>,
     *   metadata?: ?array<string, string>,
     *   processor?: ?PricingAgreementUs50Processor,
     *   gateway?: ?GatewayUs50,
     *   services?: ?array<ServiceUs50>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastUpdatedDate = $values['lastUpdatedDate'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->key = $values['key'];
        $this->metadata = $values['metadata'] ?? null;
        $this->country = $values['country'];
        $this->version = $values['version'];
        $this->base = $values['base'];
        $this->processor = $values['processor'] ?? null;
        $this->gateway = $values['gateway'] ?? null;
        $this->services = $values['services'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
