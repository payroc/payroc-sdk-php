<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about plain-text swiped card data.
 */
class PlainTextSwipedDataFormat extends JsonSerializableType
{
    /**
     * @var Device $device
     */
    #[JsonProperty('device')]
    public Device $device;

    /**
     * @var string $trackData Customer’s card data from the swiped transaction.
     */
    #[JsonProperty('trackData')]
    public string $trackData;

    /**
     * @var ?bool $fallback Indicates that this is a fallback transaction. For example, if there was a technical issue with the chip on the customer's card and the merchant then swiped the card.
     */
    #[JsonProperty('fallback')]
    public ?bool $fallback;

    /**
     * @var ?value-of<PlainTextSwipedDataFormatFallbackReason> $fallbackReason Reason for the fallback.
     */
    #[JsonProperty('fallbackReason')]
    public ?string $fallbackReason;

    /**
     * @param array{
     *   device: Device,
     *   trackData: string,
     *   fallback?: ?bool,
     *   fallbackReason?: ?value-of<PlainTextSwipedDataFormatFallbackReason>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->device = $values['device'];
        $this->trackData = $values['trackData'];
        $this->fallback = $values['fallback'] ?? null;
        $this->fallbackReason = $values['fallbackReason'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
