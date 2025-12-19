<?php

namespace Payroc\Traits;

use Payroc\Types\Currency;
use Payroc\Types\PaymentPlanBaseType;
use Payroc\Types\PaymentPlanBaseFrequency;
use Payroc\Types\PaymentPlanBaseOnUpdate;
use Payroc\Types\PaymentPlanBaseOnDelete;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * @property string $paymentPlanId
 * @property ?string $processingTerminalId
 * @property string $name
 * @property ?string $description
 * @property value-of<Currency> $currency
 * @property ?int $length
 * @property value-of<PaymentPlanBaseType> $type
 * @property value-of<PaymentPlanBaseFrequency> $frequency
 * @property value-of<PaymentPlanBaseOnUpdate> $onUpdate
 * @property value-of<PaymentPlanBaseOnDelete> $onDelete
 * @property ?array<string> $customFieldNames
 */
trait PaymentPlanBase
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
}
