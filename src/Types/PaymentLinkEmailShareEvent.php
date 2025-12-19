<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains the information about a sharing event that the merchant sent by email.
 */
class PaymentLinkEmailShareEvent extends JsonSerializableType
{
    /**
     * @var value-of<PaymentLinkEmailShareEventSharingMethod> $sharingMethod Method that the merchant uses to share the payment link.
     */
    #[JsonProperty('sharingMethod')]
    public string $sharingMethod;

    /**
     * @var ?string $sharingEventId Unique identifier that we assigned to the sharing event.
     */
    #[JsonProperty('sharingEventId')]
    public ?string $sharingEventId;

    /**
     * @var ?DateTime $dateTime Date and time that the merchant shared the link. Our gateway returns this value in the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $dateTime;

    /**
     * @var ?bool $merchantCopy Indicates if we send a copy of the email to the merchant. By default, we don't send a copy to the merchant.
     */
    #[JsonProperty('merchantCopy')]
    public ?bool $merchantCopy;

    /**
     * @var ?string $message Message that the merchant sends with the payment link.
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var array<PaymentLinkEmailRecipient> $recipients Array that contains the recipients of the payment link.
     */
    #[JsonProperty('recipients'), ArrayType([PaymentLinkEmailRecipient::class])]
    public array $recipients;

    /**
     * @param array{
     *   sharingMethod: value-of<PaymentLinkEmailShareEventSharingMethod>,
     *   recipients: array<PaymentLinkEmailRecipient>,
     *   sharingEventId?: ?string,
     *   dateTime?: ?DateTime,
     *   merchantCopy?: ?bool,
     *   message?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->sharingMethod = $values['sharingMethod'];
        $this->sharingEventId = $values['sharingEventId'] ?? null;
        $this->dateTime = $values['dateTime'] ?? null;
        $this->merchantCopy = $values['merchantCopy'] ?? null;
        $this->message = $values['message'] ?? null;
        $this->recipients = $values['recipients'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
