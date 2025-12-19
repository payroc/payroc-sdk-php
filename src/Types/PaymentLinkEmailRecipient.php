<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the contact details of the recipient.
 */
class PaymentLinkEmailRecipient extends JsonSerializableType
{
    /**
     * @var string $name Recipient's name.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var string $email Recipient's email address.
     */
    #[JsonProperty('email')]
    public string $email;

    /**
     * @param array{
     *   name: string,
     *   email: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
        $this->email = $values['email'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
