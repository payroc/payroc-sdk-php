<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains details about payment links.
 */
class ProcessingTerminalFeaturesPaymentLinks extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the terminal supports payment links.
     */
    #[JsonProperty('enabled')]
    public bool $enabled;

    /**
     * @var ?string $logoUrl URL of the logo image that the merchant wants to display in their payment link email.
     */
    #[JsonProperty('logoUrl')]
    public ?string $logoUrl;

    /**
     * @var ?string $footerNotes String that the merchant wants to display on the footer of their payment link email.
     */
    #[JsonProperty('footerNotes')]
    public ?string $footerNotes;

    /**
     * @param array{
     *   enabled: bool,
     *   logoUrl?: ?string,
     *   footerNotes?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->enabled = $values['enabled'];
        $this->logoUrl = $values['logoUrl'] ?? null;
        $this->footerNotes = $values['footerNotes'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
