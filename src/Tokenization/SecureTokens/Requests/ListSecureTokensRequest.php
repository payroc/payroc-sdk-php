<?php

namespace Payroc\Tokenization\SecureTokens\Requests;

use Payroc\Core\Json\JsonSerializableType;

class ListSecureTokensRequest extends JsonSerializableType
{
    /**
     * @var ?string $secureTokenId Unique identifier that the merchant assigned to the secure token.
     */
    public ?string $secureTokenId;

    /**
     * @var ?string $customerName Filter by the customer's name.
     */
    public ?string $customerName;

    /**
     * @var ?string $phone Filter by the customer's phone number.
     */
    public ?string $phone;

    /**
     * @var ?string $email Filter by the customer's email address.
     */
    public ?string $email;

    /**
     * @var ?string $token Filter by the token that the merchant used in a transaction to represent the customer's payment details.
     */
    public ?string $token;

    /**
     * @var ?string $first6 Filter by the first six digits of the card number.
     */
    public ?string $first6;

    /**
     * @var ?string $last4 Filter by the last four digits of the card or account number.
     */
    public ?string $last4;

    /**
     * Return the previous page of results before the value that you specify.
     *
     * You can’t send the before parameter in the same request as the after parameter.
     *
     * @var ?string $before
     */
    public ?string $before;

    /**
     * Return the next page of results after the value that you specify.
     *
     * You can’t send the after parameter in the same request as the before parameter.
     *
     * @var ?string $after
     */
    public ?string $after;

    /**
     * @var ?int $limit Limit the maximum number of results that we return for each page.
     */
    public ?int $limit;

    /**
     * @param array{
     *   secureTokenId?: ?string,
     *   customerName?: ?string,
     *   phone?: ?string,
     *   email?: ?string,
     *   token?: ?string,
     *   first6?: ?string,
     *   last4?: ?string,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->secureTokenId = $values['secureTokenId'] ?? null;
        $this->customerName = $values['customerName'] ?? null;
        $this->phone = $values['phone'] ?? null;
        $this->email = $values['email'] ?? null;
        $this->token = $values['token'] ?? null;
        $this->first6 = $values['first6'] ?? null;
        $this->last4 = $values['last4'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
