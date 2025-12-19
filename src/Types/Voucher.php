<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the EBT voucher.
 *
 * **Note:** Vouchers are available only for EBT SNAP payments.
 */
class Voucher extends JsonSerializableType
{
    /**
     * @var string $approvalCode Authorization code that the processor issued for the transaction.
     */
    #[JsonProperty('approvalCode')]
    public string $approvalCode;

    /**
     * @var string $serialNumber Serial number of the voucher.
     */
    #[JsonProperty('serialNumber')]
    public string $serialNumber;

    /**
     * @param array{
     *   approvalCode: string,
     *   serialNumber: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->approvalCode = $values['approvalCode'];
        $this->serialNumber = $values['serialNumber'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
