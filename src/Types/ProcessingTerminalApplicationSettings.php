<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the application settings for the solution.
 */
class ProcessingTerminalApplicationSettings extends JsonSerializableType
{
    /**
     * @var ?bool $invoiceNumberPrompt Indicates if the terminal should prompt the clerk to provide an invoice number with a sale.
     */
    #[JsonProperty('invoiceNumberPrompt')]
    public ?bool $invoiceNumberPrompt;

    /**
     * @var ?bool $clerkPrompt Indicates if the terminal should prompt the clerk, for example, if the terminal should prompt when the clerk needs to enter an amount on the terminal.
     */
    #[JsonProperty('clerkPrompt')]
    public ?bool $clerkPrompt;

    /**
     * @param array{
     *   invoiceNumberPrompt?: ?bool,
     *   clerkPrompt?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->invoiceNumberPrompt = $values['invoiceNumberPrompt'] ?? null;
        $this->clerkPrompt = $values['clerkPrompt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
