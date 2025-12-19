<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the shipping details for the terminal order. If you don't provide a shipping address, we use the Doing Business As (DBA) address of the processing account.
 */
class TerminalOrderShipping extends JsonSerializableType
{
    /**
     * @var ?TerminalOrderShippingPreferences $preferences Object that contains the shipping preferences for the terminal order.
     */
    #[JsonProperty('preferences')]
    public ?TerminalOrderShippingPreferences $preferences;

    /**
     * @var ?TerminalOrderShippingAddress $address Object that contains the shipping address for the terminal order.
     */
    #[JsonProperty('address')]
    public ?TerminalOrderShippingAddress $address;

    /**
     * @param array{
     *   preferences?: ?TerminalOrderShippingPreferences,
     *   address?: ?TerminalOrderShippingAddress,
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
