<?php

namespace Payroc\Traits;

use Payroc\Types\OrderItemType;
use Payroc\Types\OrderItemDeviceCondition;
use Payroc\Types\OrderItemSolutionSetup;
use Payroc\Core\Json\JsonProperty;

/**
 * @property value-of<OrderItemType> $type
 * @property string $solutionTemplateId
 * @property ?float $solutionQuantity
 * @property ?value-of<OrderItemDeviceCondition> $deviceCondition
 * @property ?OrderItemSolutionSetup $solutionSetup
 */
trait OrderItem
{
    /**
     * @var value-of<OrderItemType> $type Type of item.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * Unique identifier of the solution. Send one of the following values:
     * - `Roc Services_DX8000`
     * - `Roc Services_DX4000`
     * - `Roc Services_Web`
     * - `Roc Services_Mobile`
     * - `Payroc DX8000`
     * - `Payroc DX4000`
     * - `Payroc RX7000_Cloud`
     * - `Payroc DX8000_Cloud`
     * - `Payroc DX4000_Cloud`
     * - `Payroc A920Pro`
     * - `Payroc A80`
     * - `Payroc A920Pro_Cloud`
     * - `Payroc A80_Cloud`
     * - `Roc Terminal Plus_N950`
     * - `Roc Terminal Plus_N950-S`
     * - `Roc Terminal Plus_X800`
     * - `Gateway_Payroc`
     * - `VAR_Only_TSYS`
     * - `ROC Services Chipper3X`
     * - `BBPOS Chipper 3X`
     * - `Augusta EMV`
     * - `Ingenico - AXIUM Full Functional Base`
     * - `Pax A920 Charging Base`
     * - `Pax A920 Comms Base`
     * - `A920 Pro Ethernet`
     * - `Axium Bundle`
     *
     * @var string $solutionTemplateId
     */
    #[JsonProperty('solutionTemplateId')]
    public string $solutionTemplateId;

    /**
     * @var ?float $solutionQuantity Quantity of the solution.
     */
    #[JsonProperty('solutionQuantity')]
    public ?float $solutionQuantity;

    /**
     * @var ?value-of<OrderItemDeviceCondition> $deviceCondition Indicates if the order contains a new item or a refurbished item.
     */
    #[JsonProperty('deviceCondition')]
    public ?string $deviceCondition;

    /**
     * @var ?OrderItemSolutionSetup $solutionSetup Object that contains the settings for the solution, including gateway settings, device settings, and application settings.
     */
    #[JsonProperty('solutionSetup')]
    public ?OrderItemSolutionSetup $solutionSetup;
}
