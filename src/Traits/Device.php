<?php

namespace Payroc\Traits;

use Payroc\Types\DeviceModel;
use Payroc\Types\DeviceCategory;
use Payroc\Types\DeviceConfig;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the physical device the merchant used to capture the customer’s card details.
 *
 * @property value-of<DeviceModel> $model
 * @property ?value-of<DeviceCategory> $category
 * @property string $serialNumber
 * @property ?string $firmwareVersion
 * @property ?DeviceConfig $config
 */
trait Device
{
    /**
     * @var value-of<DeviceModel> $model Model of the device that the merchant used to process the transaction.
     */
    #[JsonProperty('model')]
    public string $model;

    /**
     * @var ?value-of<DeviceCategory> $category Indicates if the device is attended or unattended.
     */
    #[JsonProperty('category')]
    public ?string $category;

    /**
     * @var string $serialNumber Serial number of the physical device.
     */
    #[JsonProperty('serialNumber')]
    public string $serialNumber;

    /**
     * @var ?string $firmwareVersion Firmware version of the physical device.
     */
    #[JsonProperty('firmwareVersion')]
    public ?string $firmwareVersion;

    /**
     * @var ?DeviceConfig $config
     */
    #[JsonProperty('config')]
    public ?DeviceConfig $config;
}
