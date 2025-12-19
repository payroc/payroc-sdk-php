<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Tip settings
 */
class TipProcessingEnabled extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the terminal can accept tips.
     */
    #[JsonProperty('enabled')]
    public bool $enabled;

    /**
     * @var ?bool $tipPrompt Indicates if the terminal prompts for tips.
     */
    #[JsonProperty('tipPrompt')]
    public ?bool $tipPrompt;

    /**
     * @var ?bool $tipAdjust Indicates if a clerk can adjust a tip after the customer completes the sale.
     */
    #[JsonProperty('tipAdjust')]
    public ?bool $tipAdjust;

    /**
     * @var ?TipProcessingEnabledSuggestedTips $suggestedTips Object that contains up to three tip amounts that the terminal displays during a sale.
     */
    #[JsonProperty('suggestedTips')]
    public ?TipProcessingEnabledSuggestedTips $suggestedTips;

    /**
     * @param array{
     *   enabled: bool,
     *   tipPrompt?: ?bool,
     *   tipAdjust?: ?bool,
     *   suggestedTips?: ?TipProcessingEnabledSuggestedTips,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->enabled = $values['enabled'];
        $this->tipPrompt = $values['tipPrompt'] ?? null;
        $this->tipAdjust = $values['tipAdjust'] ?? null;
        $this->suggestedTips = $values['suggestedTips'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
