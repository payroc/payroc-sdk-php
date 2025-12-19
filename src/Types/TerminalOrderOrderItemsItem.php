<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\OrderItem;
use Payroc\Traits\Links;

class TerminalOrderOrderItemsItem extends JsonSerializableType
{
    use OrderItem;
    use Links;


    /**
     * @param array{
     *   type: value-of<OrderItemType>,
     *   solutionTemplateId: string,
     *   solutionQuantity?: ?float,
     *   deviceCondition?: ?value-of<OrderItemDeviceCondition>,
     *   solutionSetup?: ?OrderItemSolutionSetup,
     *   links?: ?array<ProcessingTerminalSummary>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->solutionTemplateId = $values['solutionTemplateId'];
        $this->solutionQuantity = $values['solutionQuantity'] ?? null;
        $this->deviceCondition = $values['deviceCondition'] ?? null;
        $this->solutionSetup = $values['solutionSetup'] ?? null;
        $this->links = $values['links'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
