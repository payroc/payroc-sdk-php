<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the customer and their shipping address.
 */
class RetrievedShipping extends JsonSerializableType
{
    /**
     * @var ?string $recipientName Recipient's name.
     */
    #[JsonProperty('recipientName')]
    public ?string $recipientName;

    /**
     * @var ?RetrievedAddress $address
     */
    #[JsonProperty('address')]
    public ?RetrievedAddress $address;

    /**
     * @param array{
     *   recipientName?: ?string,
     *   address?: ?RetrievedAddress,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->recipientName = $values['recipientName'] ?? null;
        $this->address = $values['address'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
