<?php

namespace Payroc\Tokenization\SecureTokens\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Tokenization\SecureTokens\Types\TokenizationRequestMitAgreement;
use Payroc\Types\Customer;
use Payroc\Types\IpAddress;
use Payroc\Tokenization\SecureTokens\Types\TokenizationRequestSource;
use Payroc\Tokenization\SecureTokens\Types\TokenizationRequestThreeDSecure;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class TokenizationRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * Unique identifier that the merchant created for the secure token that represents the customer's payment details.
     * If the merchant doesn't create a secureTokenId, the gateway generates one and returns it in the response.
     *
     * @var ?string $secureTokenId
     */
    #[JsonProperty('secureTokenId')]
    public ?string $secureTokenId;

    /**
     * @var ?string $operator Operator who saved the customer's payment details.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * Indicates how the merchant can use the customer's card details, as agreed by the customer:
     *
     * - `unscheduled` - Transactions for a fixed or variable amount that are run at a certain pre-defined event.
     * - `recurring` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Recurring transactions don't have a fixed duration and run until the customer cancels the agreement.
     * - `installment` - Transactions for a fixed amount that are run at regular intervals, for example, monthly. Installment transactions have a fixed duration.
     *
     * @var ?value-of<TokenizationRequestMitAgreement> $mitAgreement
     */
    #[JsonProperty('mitAgreement')]
    public ?string $mitAgreement;

    /**
     * @var ?Customer $customer
     */
    #[JsonProperty('customer')]
    public ?Customer $customer;

    /**
     * @var ?IpAddress $ipAddress
     */
    #[JsonProperty('ipAddress')]
    public ?IpAddress $ipAddress;

    /**
     * @var TokenizationRequestSource $source Object that contains information about the payment method to tokenize.
     */
    #[JsonProperty('source')]
    public TokenizationRequestSource $source;

    /**
     * @var ?TokenizationRequestThreeDSecure $threeDSecure Object that contains information for an authentication check on the customer's payment details using the 3-D Secure protocol.
     */
    #[JsonProperty('threeDSecure')]
    public ?TokenizationRequestThreeDSecure $threeDSecure;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   source: TokenizationRequestSource,
     *   secureTokenId?: ?string,
     *   operator?: ?string,
     *   mitAgreement?: ?value-of<TokenizationRequestMitAgreement>,
     *   customer?: ?Customer,
     *   ipAddress?: ?IpAddress,
     *   threeDSecure?: ?TokenizationRequestThreeDSecure,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->secureTokenId = $values['secureTokenId'] ?? null;
        $this->operator = $values['operator'] ?? null;
        $this->mitAgreement = $values['mitAgreement'] ?? null;
        $this->customer = $values['customer'] ?? null;
        $this->ipAddress = $values['ipAddress'] ?? null;
        $this->source = $values['source'];
        $this->threeDSecure = $values['threeDSecure'] ?? null;
        $this->customFields = $values['customFields'] ?? null;
    }
}
