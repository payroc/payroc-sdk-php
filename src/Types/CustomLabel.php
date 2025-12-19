<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the information for the custom label.
 */
class CustomLabel extends JsonSerializableType
{
    /**
     * @var ?value-of<CustomLabelElement> $element Element that you want to provide a custom label for.
     */
    #[JsonProperty('element')]
    public ?string $element;

    /**
     * @var ?string $label Custom label to display on the element.
     */
    #[JsonProperty('label')]
    public ?string $label;

    /**
     * @param array{
     *   element?: ?value-of<CustomLabelElement>,
     *   label?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->element = $values['element'] ?? null;
        $this->label = $values['label'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
