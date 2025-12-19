<?php

namespace Payroc\Boarding\ProcessingAccounts\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the shipping address for the terminal order.
 */
class CreateTerminalOrderShippingAddress extends JsonSerializableType
{
    /**
     * @var string $recipientName Name of the person receiving the shipment.
     */
    #[JsonProperty('recipientName')]
    public string $recipientName;

    /**
     * @var ?string $businessName Name of the business receiving the shipment.
     */
    #[JsonProperty('businessName')]
    public ?string $businessName;

    /**
     * @var string $addressLine1 First line of the shipment address.
     */
    #[JsonProperty('addressLine1')]
    public string $addressLine1;

    /**
     * @var ?string $addressLine2 Second line of the shipment address.
     */
    #[JsonProperty('addressLine2')]
    public ?string $addressLine2;

    /**
     * @var string $city City of the shipment address.
     */
    #[JsonProperty('city')]
    public string $city;

    /**
     * @var string $state State of the shipment address.
     */
    #[JsonProperty('state')]
    public string $state;

    /**
     * @var string $postalCode Postal code of the shipment address.
     */
    #[JsonProperty('postalCode')]
    public string $postalCode;

    /**
     * @var string $email Contact email address for the shipment.
     */
    #[JsonProperty('email')]
    public string $email;

    /**
     * @var ?string $phone Contact number for the shipment.
     */
    #[JsonProperty('phone')]
    public ?string $phone;

    /**
     * @param array{
     *   recipientName: string,
     *   addressLine1: string,
     *   city: string,
     *   state: string,
     *   postalCode: string,
     *   email: string,
     *   businessName?: ?string,
     *   addressLine2?: ?string,
     *   phone?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->recipientName = $values['recipientName'];
        $this->businessName = $values['businessName'] ?? null;
        $this->addressLine1 = $values['addressLine1'];
        $this->addressLine2 = $values['addressLine2'] ?? null;
        $this->city = $values['city'];
        $this->state = $values['state'];
        $this->postalCode = $values['postalCode'];
        $this->email = $values['email'];
        $this->phone = $values['phone'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
