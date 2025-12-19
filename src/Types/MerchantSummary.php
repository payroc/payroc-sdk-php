<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the merchant.
 */
class MerchantSummary extends JsonSerializableType
{
    /**
     * @var ?string $merchantId Unique identifier that the processor assigned to the merchant.
     */
    #[JsonProperty('merchantId')]
    public ?string $merchantId;

    /**
     * @var ?string $doingBusinessAs Trading name of the business.
     */
    #[JsonProperty('doingBusinessAs')]
    public ?string $doingBusinessAs;

    /**
     * @var ?int $processingAccountId Unique identifier that we assigned to the processing account.
     */
    #[JsonProperty('processingAccountId')]
    public ?int $processingAccountId;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   merchantId?: ?string,
     *   doingBusinessAs?: ?string,
     *   processingAccountId?: ?int,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->merchantId = $values['merchantId'] ?? null;
        $this->doingBusinessAs = $values['doingBusinessAs'] ?? null;
        $this->processingAccountId = $values['processingAccountId'] ?? null;
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
