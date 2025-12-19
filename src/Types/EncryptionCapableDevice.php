<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\Device;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the encryption details of the POS terminal.
 */
class EncryptionCapableDevice extends JsonSerializableType
{
    use Device;

    /**
     * @var ?string $dataKsn Key serial number.
     */
    #[JsonProperty('dataKsn')]
    public ?string $dataKsn;

    /**
     * @param array{
     *   model: value-of<DeviceModel>,
     *   serialNumber: string,
     *   category?: ?value-of<DeviceCategory>,
     *   firmwareVersion?: ?string,
     *   config?: ?DeviceConfig,
     *   dataKsn?: ?string,
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
        $this->dataKsn = $values['dataKsn'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
