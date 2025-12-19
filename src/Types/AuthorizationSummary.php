<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the authorization.
 */
class AuthorizationSummary extends JsonSerializableType
{
    /**
     * @var ?int $authorizationId Unique identifier of the authorization.
     */
    #[JsonProperty('authorizationId')]
    public ?int $authorizationId;

    /**
     * Authorization code.
     *
     * **Note:** For returns, the card brands may not provide an authorization code.
     *
     * @var ?string $code
     */
    #[JsonProperty('code')]
    public ?string $code;

    /**
     * @var ?int $amount Authorization amount. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?string $avsResponseCode Response code that indicates if the address matches the address registered to the customer.
     */
    #[JsonProperty('avsResponseCode')]
    public ?string $avsResponseCode;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   authorizationId?: ?int,
     *   code?: ?string,
     *   amount?: ?int,
     *   avsResponseCode?: ?string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->authorizationId = $values['authorizationId'] ?? null;
        $this->code = $values['code'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->avsResponseCode = $values['avsResponseCode'] ?? null;
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
