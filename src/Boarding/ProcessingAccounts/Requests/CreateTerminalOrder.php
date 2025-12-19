<?php

namespace Payroc\Boarding\ProcessingAccounts\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\TrainingProvider;
use Payroc\Core\Json\JsonProperty;
use Payroc\Boarding\ProcessingAccounts\Types\CreateTerminalOrderShipping;
use Payroc\Types\OrderItem;
use Payroc\Core\Types\ArrayType;

class CreateTerminalOrder extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?value-of<TrainingProvider> $trainingProvider
     */
    #[JsonProperty('trainingProvider')]
    public ?string $trainingProvider;

    /**
     * @var ?CreateTerminalOrderShipping $shipping Object that contains the shipping details for the terminal order. If you don't provide a shipping address, we use the Doing Business As (DBA) address of the processing account.
     */
    #[JsonProperty('shipping')]
    public ?CreateTerminalOrderShipping $shipping;

    /**
     * @var array<OrderItem> $orderItems Array of order items. Provide a minimum of 1 order item and a maximum of 10 order items.
     */
    #[JsonProperty('orderItems'), ArrayType([OrderItem::class])]
    public array $orderItems;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   orderItems: array<OrderItem>,
     *   trainingProvider?: ?value-of<TrainingProvider>,
     *   shipping?: ?CreateTerminalOrderShipping,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->trainingProvider = $values['trainingProvider'] ?? null;
        $this->shipping = $values['shipping'] ?? null;
        $this->orderItems = $values['orderItems'];
    }
}
