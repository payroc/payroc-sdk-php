<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about other speciality cards that the merchant accepts.
 */
class ProcessingCardAcceptanceSpecialityCardsOther extends JsonSerializableType
{
    /**
     * @var ?string $wexMerchantNumber If the merchant accepts WEX, provide their WEX merchant number.
     */
    #[JsonProperty('wexMerchantNumber')]
    public ?string $wexMerchantNumber;

    /**
     * @var ?string $voyagerMerchantId If the merchant accepts Voyager, provide their Voyager merchant ID.
     */
    #[JsonProperty('voyagerMerchantId')]
    public ?string $voyagerMerchantId;

    /**
     * @var ?string $fleetMerchantId If the merchant accepts Fleet, provide their Fleet merchant ID.
     */
    #[JsonProperty('fleetMerchantId')]
    public ?string $fleetMerchantId;

    /**
     * @param array{
     *   wexMerchantNumber?: ?string,
     *   voyagerMerchantId?: ?string,
     *   fleetMerchantId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->wexMerchantNumber = $values['wexMerchantNumber'] ?? null;
        $this->voyagerMerchantId = $values['voyagerMerchantId'] ?? null;
        $this->fleetMerchantId = $values['fleetMerchantId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
