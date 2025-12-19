<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the physical device the merchant used to capture the customer’s card details.
 */
class Device extends JsonSerializableType
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

    /**
     * @param array{
     *   model: value-of<DeviceModel>,
     *   serialNumber: string,
     *   category?: ?value-of<DeviceCategory>,
     *   firmwareVersion?: ?string,
     *   config?: ?DeviceConfig,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->model = $values['model'];
        $this->category = $values['category'] ?? null;
        $this->serialNumber = $values['serialNumber'];
        $this->firmwareVersion = $values['firmwareVersion'] ?? null;
        $this->config = $values['config'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
