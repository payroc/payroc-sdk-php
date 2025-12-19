<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;
use DateTime;
use Payroc\Core\Types\Date;

class TerminalOrder extends JsonSerializableType
{
    /**
     * @var string $terminalOrderId Unique identifier that we assigned to the terminal order.
     */
    #[JsonProperty('terminalOrderId')]
    public string $terminalOrderId;

    /**
     * Status of the terminal order.
     *
     * **Note**: You can subscribe to our terminalOrder.status.changed event to get notifications when we update the status of a terminal order. For more information about how to subscribe to events, go to [Event Subscriptions](https://docs.payroc.com/guides/integrate/event-subscriptions).
     *
     * @var value-of<TerminalOrderStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?value-of<TerminalOrderTrainingProvider> $trainingProvider Indicates who provides training to the merchant for the solution.
     */
    #[JsonProperty('trainingProvider')]
    public ?string $trainingProvider;

    /**
     * @var ?TerminalOrderShipping $shipping Object that contains the shipping details for the terminal order. If you don't provide a shipping address, we use the Doing Business As (DBA) address of the processing account.
     */
    #[JsonProperty('shipping')]
    public ?TerminalOrderShipping $shipping;

    /**
     * @var array<TerminalOrderOrderItemsItem> $orderItems Array of orderItem objects. Provide a minimum of 1 order item and a maximum of 20 order items.
     */
    #[JsonProperty('orderItems'), ArrayType([TerminalOrderOrderItemsItem::class])]
    public array $orderItems;

    /**
     * @var ?DateTime $createdDate Date that we received the terminal order. We return this value in the [ISO-8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date that the terminal order was last changed.  We return this value in the [ISO-8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $lastModifiedDate;

    /**
     * @param array{
     *   terminalOrderId: string,
     *   status: value-of<TerminalOrderStatus>,
     *   orderItems: array<TerminalOrderOrderItemsItem>,
     *   trainingProvider?: ?value-of<TerminalOrderTrainingProvider>,
     *   shipping?: ?TerminalOrderShipping,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->terminalOrderId = $values['terminalOrderId'];
        $this->status = $values['status'];
        $this->trainingProvider = $values['trainingProvider'] ?? null;
        $this->shipping = $values['shipping'] ?? null;
        $this->orderItems = $values['orderItems'];
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
