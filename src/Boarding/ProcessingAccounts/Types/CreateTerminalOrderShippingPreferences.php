<?php

namespace Payroc\Boarding\ProcessingAccounts\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the shipping preferences for the terminal order.
 */
class CreateTerminalOrderShippingPreferences extends JsonSerializableType
{
    /**
     * Shipping method for the terminal order. Send one of the following values:
     *   - `nextDay` - We schedule the order to be delivered the next day.
     *   - `ground` - We ship the order with ground shipping.
     *
     * @var ?value-of<CreateTerminalOrderShippingPreferencesMethod> $method
     */
    #[JsonProperty('method')]
    public ?string $method;

    /**
     * @var ?bool $saturdayDelivery Indicates if we can schedule the terminal order to be delivered on a Saturday.
     */
    #[JsonProperty('saturdayDelivery')]
    public ?bool $saturdayDelivery;

    /**
     * @param array{
     *   method?: ?value-of<CreateTerminalOrderShippingPreferencesMethod>,
     *   saturdayDelivery?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->method = $values['method'] ?? null;
        $this->saturdayDelivery = $values['saturdayDelivery'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
