<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the device settings if the solution includes a terminal or a peripheral device such as a printer.
 */
class OrderItemSolutionSetupDeviceSettings extends JsonSerializableType
{
    /**
     * @var ?float $numberOfMobileUsers Number of users that we need to set up for mobile solutions.
     */
    #[JsonProperty('numberOfMobileUsers')]
    public ?float $numberOfMobileUsers;

    /**
     * @var ?value-of<OrderItemSolutionSetupDeviceSettingsCommunicationType> $communicationType Method of connection between a terminal or a peripheral device and the host.
     */
    #[JsonProperty('communicationType')]
    public ?string $communicationType;

    /**
     * @param array{
     *   numberOfMobileUsers?: ?float,
     *   communicationType?: ?value-of<OrderItemSolutionSetupDeviceSettingsCommunicationType>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->numberOfMobileUsers = $values['numberOfMobileUsers'] ?? null;
        $this->communicationType = $values['communicationType'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
