<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the plain-text card data for keyed transactions.
 */
class PlainTextKeyedDataFormat extends JsonSerializableType
{
    /**
     * @var ?Device $device
     */
    #[JsonProperty('device')]
    public ?Device $device;

    /**
     * @var string $cardNumber Customer’s card number.
     */
    #[JsonProperty('cardNumber')]
    public string $cardNumber;

    /**
     * Expiry date of the customer’s card.
     * **Note:** We require you to send an expiry date for most BIN lookups and electronic voucher transactions.
     *
     * @var ?string $expiryDate
     */
    #[JsonProperty('expiryDate')]
    public ?string $expiryDate;

    /**
     * @var ?string $cvv Security code of the customer’s card.
     */
    #[JsonProperty('cvv')]
    public ?string $cvv;

    /**
     * @var ?string $issueNumber Issue number of the customer’s card.
     */
    #[JsonProperty('issueNumber')]
    public ?string $issueNumber;

    /**
     * @param array{
     *   cardNumber: string,
     *   device?: ?Device,
     *   expiryDate?: ?string,
     *   cvv?: ?string,
     *   issueNumber?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->device = $values['device'] ?? null;
        $this->cardNumber = $values['cardNumber'];
        $this->expiryDate = $values['expiryDate'] ?? null;
        $this->cvv = $values['cvv'] ?? null;
        $this->issueNumber = $values['issueNumber'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
