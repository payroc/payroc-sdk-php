<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the application settings for the solution.
 */
class OrderItemSolutionSetupApplicationSettings extends JsonSerializableType
{
    /**
     * @var ?bool $clerkPrompt Indicates if the terminal should prompt the clerk, for example, if the terminal should prompt when the clerk needs to enter an amount on the terminal.
     */
    #[JsonProperty('clerkPrompt')]
    public ?bool $clerkPrompt;

    /**
     * @var ?OrderItemSolutionSetupApplicationSettingsSecurity $security Object that contains the password settings when running specific transaction types.
     */
    #[JsonProperty('security')]
    public ?OrderItemSolutionSetupApplicationSettingsSecurity $security;

    /**
     * @param array{
     *   clerkPrompt?: ?bool,
     *   security?: ?OrderItemSolutionSetupApplicationSettingsSecurity,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->clerkPrompt = $values['clerkPrompt'] ?? null;
        $this->security = $values['security'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
