<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains the customer's contact details and address information.
 */
class Customer extends JsonSerializableType
{
    /**
     * @var ?string $firstName Customer's first name.
     */
    #[JsonProperty('firstName')]
    public ?string $firstName;

    /**
     * @var ?string $lastName Customer's last name.
     */
    #[JsonProperty('lastName')]
    public ?string $lastName;

    /**
     * @var ?DateTime $dateOfBirth Customer's date of birth. The format for this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('dateOfBirth'), Date(Date::TYPE_DATE)]
    public ?DateTime $dateOfBirth;

    /**
     * Identifier of the transaction, also known as a customer code.
     *
     * For requests, you must send a value for **referenceNumber** if the customer provides one.
     *
     * @var ?string $referenceNumber
     */
    #[JsonProperty('referenceNumber')]
    public ?string $referenceNumber;

    /**
     * @var ?Address $billingAddress Object that contains information about the address that the card is registered to.
     */
    #[JsonProperty('billingAddress')]
    public ?Address $billingAddress;

    /**
     * @var ?Shipping $shippingAddress
     */
    #[JsonProperty('shippingAddress')]
    public ?Shipping $shippingAddress;

    /**
     * @var ?array<ContactMethod> $contactMethods Customer's contact information.
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public ?array $contactMethods;

    /**
     * @var ?value-of<CustomerNotificationLanguage> $notificationLanguage Language that the customer uses for notifications. This code follows the [ISO 639-1](https://www.iso.org/iso-639-language-code) alpha-2 standard.
     */
    #[JsonProperty('notificationLanguage')]
    public ?string $notificationLanguage;

    /**
     * @param array{
     *   firstName?: ?string,
     *   lastName?: ?string,
     *   dateOfBirth?: ?DateTime,
     *   referenceNumber?: ?string,
     *   billingAddress?: ?Address,
     *   shippingAddress?: ?Shipping,
     *   contactMethods?: ?array<ContactMethod>,
     *   notificationLanguage?: ?value-of<CustomerNotificationLanguage>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
        $this->dateOfBirth = $values['dateOfBirth'] ?? null;
        $this->referenceNumber = $values['referenceNumber'] ?? null;
        $this->billingAddress = $values['billingAddress'] ?? null;
        $this->shippingAddress = $values['shippingAddress'] ?? null;
        $this->contactMethods = $values['contactMethods'] ?? null;
        $this->notificationLanguage = $values['notificationLanguage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
