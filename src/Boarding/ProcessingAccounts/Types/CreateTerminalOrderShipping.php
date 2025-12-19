<?php

namespace Payroc\Boarding\ProcessingAccounts\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the shipping details for the terminal order. If you don't provide a shipping address, we use the Doing Business As (DBA) address of the processing account.
 */
class CreateTerminalOrderShipping extends JsonSerializableType
{
    /**
     * @var ?CreateTerminalOrderShippingPreferences $preferences Object that contains the shipping preferences for the terminal order.
     */
    #[JsonProperty('preferences')]
    public ?CreateTerminalOrderShippingPreferences $preferences;

    /**
     * @var ?CreateTerminalOrderShippingAddress $address Object that contains the shipping address for the terminal order.
     */
    #[JsonProperty('address')]
    public ?CreateTerminalOrderShippingAddress $address;

    /**
     * @param array{
     *   preferences?: ?CreateTerminalOrderShippingPreferences,
     *   address?: ?CreateTerminalOrderShippingAddress,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->preferences = $values['preferences'] ?? null;
        $this->address = $values['address'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
