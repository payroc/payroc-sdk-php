<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the secure token.
 */
class SecureTokenSummary extends JsonSerializableType
{
    /**
     * @var string $secureTokenId Unique identifier that the merchant assigned to the secure token.
     */
    #[JsonProperty('secureTokenId')]
    public string $secureTokenId;

    /**
     * @var string $customerName Customer's name.
     */
    #[JsonProperty('customerName')]
    public string $customerName;

    /**
     * Token that the merchant can use in future transactions to represent the customer's payment details. The token:
     * - Begins with the six-digit identification number **296753**.
     * - Contains up to 12 digits.
     * - Contains a single check digit that we calculate using the Luhn algorithm.
     *
     * @var string $token
     */
    #[JsonProperty('token')]
    public string $token;

    /**
     * Status of the customer's bank account. The processor performs a security check on the customer's bank account and returns the status of the account.
     * **Note:** Depending on the merchant's account settings, this feature may be unavailable.
     *
     * @var value-of<SecureTokenSummaryStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   secureTokenId: string,
     *   customerName: string,
     *   token: string,
     *   status: value-of<SecureTokenSummaryStatus>,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->secureTokenId = $values['secureTokenId'];
        $this->customerName = $values['customerName'];
        $this->token = $values['token'];
        $this->status = $values['status'];
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
