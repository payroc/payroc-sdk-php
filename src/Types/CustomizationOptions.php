<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains available options to customize certain aspects of an instruction.
 */
class CustomizationOptions extends JsonSerializableType
{
    /**
     * @var ?EbtDetails $ebtDetails
     */
    #[JsonProperty('ebtDetails')]
    public ?EbtDetails $ebtDetails;

    /**
     * Indicates how you want the device to capture the card details.
     * - `deviceRead` - Device prompts the cardholder to tap, swipe, or insert their card.
     * - `manualEntry` - Device prompts the merchant or cardholder to manually enter card details.
     * - `deviceReadOrManualEntry` - Device prompts the cardholder to tap, swipe, or insert their card. The device also displays an option for the merchant or cardholder to manually enter card details.
     *
     * @var ?value-of<CustomizationOptionsEntryMethod> $entryMethod
     */
    #[JsonProperty('entryMethod')]
    public ?string $entryMethod;

    /**
     * @param array{
     *   ebtDetails?: ?EbtDetails,
     *   entryMethod?: ?value-of<CustomizationOptionsEntryMethod>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->ebtDetails = $values['ebtDetails'] ?? null;
        $this->entryMethod = $values['entryMethod'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
