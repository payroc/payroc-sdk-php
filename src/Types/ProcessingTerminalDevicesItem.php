<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the details of the device.
 */
class ProcessingTerminalDevicesItem extends JsonSerializableType
{
    /**
     * @var string $manufacturer Manufacturer of the terminal.
     */
    #[JsonProperty('manufacturer')]
    public string $manufacturer;

    /**
     * @var string $model Model of the terminal.
     */
    #[JsonProperty('model')]
    public string $model;

    /**
     * @var string $serialNumber Serial number of the terminal.
     */
    #[JsonProperty('serialNumber')]
    public string $serialNumber;

    /**
     * @var ?value-of<CommunicationType> $communicationType
     */
    #[JsonProperty('communicationType')]
    public ?string $communicationType;

    /**
     * @param array{
     *   manufacturer: string,
     *   model: string,
     *   serialNumber: string,
     *   communicationType?: ?value-of<CommunicationType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->manufacturer = $values['manufacturer'];
        $this->model = $values['model'];
        $this->serialNumber = $values['serialNumber'];
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
