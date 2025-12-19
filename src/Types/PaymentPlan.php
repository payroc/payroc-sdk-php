<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PaymentPlanBase;
use Payroc\Core\Json\JsonProperty;

class PaymentPlan extends JsonSerializableType
{
    use PaymentPlanBase;

    /**
     * @var ?PaymentPlanSetupOrder $setupOrder
     */
    #[JsonProperty('setupOrder')]
    public ?PaymentPlanSetupOrder $setupOrder;

    /**
     * @var ?PaymentPlanRecurringOrder $recurringOrder
     */
    #[JsonProperty('recurringOrder')]
    public ?PaymentPlanRecurringOrder $recurringOrder;

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
     *   setupOrder?: ?PaymentPlanSetupOrder,
     *   recurringOrder?: ?PaymentPlanRecurringOrder,
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
        $this->setupOrder = $values['setupOrder'] ?? null;
        $this->recurringOrder = $values['recurringOrder'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
