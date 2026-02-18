<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the customer.
 */
class BankTransferCustomer extends JsonSerializableType
{
    /**
     * @var ?value-of<BankTransferCustomerNotificationLanguage> $notificationLanguage Customer's preferred notification language. This code follows the [ISO 639-1](https://www.iso.org/iso-639-language-code) standard.
     */
    #[JsonProperty('notificationLanguage')]
    public ?string $notificationLanguage;

    /**
     * Array of polymorphic objects, which contain contact information.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`email` - Email address
     * -	`phone` - Phone number
     * -	`mobile` - Mobile number
     * -	`fax` - Fax number
     *
     * @var ?array<ContactMethod> $contactMethods
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public ?array $contactMethods;

    /**
     * @param array{
     *   notificationLanguage?: ?value-of<BankTransferCustomerNotificationLanguage>,
     *   contactMethods?: ?array<ContactMethod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->notificationLanguage = $values['notificationLanguage'] ?? null;
        $this->contactMethods = $values['contactMethods'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
