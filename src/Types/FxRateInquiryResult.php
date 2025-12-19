<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that indicates if the customer's card is eligible for Dynamic Currency Conversion (DCC).
 */
class FxRateInquiryResult extends JsonSerializableType
{
    /**
     * @var bool $dccOffered Indicates if the card is eligible for Dynamic Currency Conversion (DCC).
     */
    #[JsonProperty('dccOffered')]
    public bool $dccOffered;

    /**
     * @var ?string $causeOfRejection Explains why the DCC service did not offer a currency conversion rate to the customer.
     */
    #[JsonProperty('causeOfRejection')]
    public ?string $causeOfRejection;

    /**
     * @param array{
     *   dccOffered: bool,
     *   causeOfRejection?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->dccOffered = $values['dccOffered'];
        $this->causeOfRejection = $values['causeOfRejection'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
