<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class PaymentPlanBase extends JsonSerializableType
{
    /**
     * @var string $paymentPlanId Unique identifier that the merchant assigns to the payment plan.
     */
    #[JsonProperty('paymentPlanId')]
    public string $paymentPlanId;

    /**
     * @var ?string $processingTerminalId Unique identifier of the terminal that the payment plan is assigned to.
     */
    #[JsonProperty('processingTerminalId')]
    public ?string $processingTerminalId;

    /**
     * @var string $name Name of the payment plan.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var ?string $description Description of the payment plan.
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * Number of payments for the payment plan.
     *
     * To indicate that the payment plan should run indefinitely, send a value of `0`.
     *
     * @var ?int $length
     */
    #[JsonProperty('length')]
    public ?int $length;

    /**
     * Indicates how the merchant takes the payment from the customer's account.
     * - `manual` - The merchant manually collects payments from the customer.
     * - `automatic` - The terminal automatically collects payments from the customer.
     *
     * @var value-of<PaymentPlanBaseType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var value-of<PaymentPlanBaseFrequency> $frequency Indicates how often the merchant or the terminal collects a payment from the customer.
     */
    #[JsonProperty('frequency')]
    public string $frequency;

    /**
     * Indicates whether any changes that the merchant makes to the payment plan apply to existing subscriptions.
     * - `update` - Changes apply to existing subscriptions.
     * - `continue` - Changes don't apply to existing subscriptions.
     *
     * @var value-of<PaymentPlanBaseOnUpdate> $onUpdate
     */
    #[JsonProperty('onUpdate')]
    public string $onUpdate;

    /**
     * Indicates what happens to existing subscriptions if the merchant deletes the payment plan.
     * - `complete` - Stops existing subscriptions.
     * - `continue` - Continues existing subscriptions.
     *
     * @var value-of<PaymentPlanBaseOnDelete> $onDelete
     */
    #[JsonProperty('onDelete')]
    public string $onDelete;

    /**
     * @var ?array<string> $customFieldNames Array of custom fields that you can use in subscriptions linked to the payment plan.
     */
    #[JsonProperty('customFieldNames'), ArrayType(['string'])]
    public ?array $customFieldNames;

    /**
     * @param array{
     *   paymentPlanId: string,
     *   name: string,
     *   currency: value-of<Currency>,
     *   type: value-of<PaymentPlanBaseType>,
     *   frequency: value-of<PaymentPlanBaseFrequency>,
     *   onUpdate: value-of<PaymentPlanBaseOnUpdate>,
     *   onDelete: value-of<PaymentPlanBaseOnDelete>,
     *   processingTerminalId?: ?string,
     *   description?: ?string,
     *   length?: ?int,
     *   customFieldNames?: ?array<string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentPlanId = $values['paymentPlanId'];
        $this->processingTerminalId = $values['processingTerminalId'] ?? null;
        $this->name = $values['name'];
        $this->description = $values['description'] ?? null;
        $this->currency = $values['currency'];
        $this->length = $values['length'] ?? null;
        $this->type = $values['type'];
        $this->frequency = $values['frequency'];
        $this->onUpdate = $values['onUpdate'];
        $this->onDelete = $values['onDelete'];
        $this->customFieldNames = $values['customFieldNames'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
