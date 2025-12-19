<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains details about level two and level three transactions.
 */
class ProcessingTerminalFeaturesEnhancedProcessing extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the terminal can run level two and level three transactions.
     */
    #[JsonProperty('enabled')]
    public bool $enabled;

    /**
     * @var ?value-of<ProcessingTerminalFeaturesEnhancedProcessingTransactionDataLevel> $transactionDataLevel Indicates if the terminal supports level two or level three transactions.
     */
    #[JsonProperty('transactionDataLevel')]
    public ?string $transactionDataLevel;

    /**
     * Indicates the address information that the clerk must provide to qualify for level two or level three data. The value is one of the following:
     * - `fullAddress` - The clerk must provide the full address for the transaction to qualify.
     * - `postalCode` - The clerk must provide a postal code for the transaction to qualify.
     *
     * @var ?value-of<ProcessingTerminalFeaturesEnhancedProcessingShippingAddressMode> $shippingAddressMode
     */
    #[JsonProperty('shippingAddressMode')]
    public ?string $shippingAddressMode;

    /**
     * @param array{
     *   enabled: bool,
     *   transactionDataLevel?: ?value-of<ProcessingTerminalFeaturesEnhancedProcessingTransactionDataLevel>,
     *   shippingAddressMode?: ?value-of<ProcessingTerminalFeaturesEnhancedProcessingShippingAddressMode>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->enabled = $values['enabled'];
        $this->transactionDataLevel = $values['transactionDataLevel'] ?? null;
        $this->shippingAddressMode = $values['shippingAddressMode'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
