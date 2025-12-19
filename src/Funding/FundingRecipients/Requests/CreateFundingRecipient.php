<?php

namespace Payroc\Funding\FundingRecipients\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Funding\FundingRecipients\Types\CreateFundingRecipientRecipientType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\Address;
use Payroc\Types\ContactMethod;
use Payroc\Core\Types\ArrayType;
use Payroc\Types\Owner;
use Payroc\Types\FundingAccount;

class CreateFundingRecipient extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var value-of<CreateFundingRecipientRecipientType> $recipientType Type or legal structure of the funding recipient.
     */
    #[JsonProperty('recipientType')]
    public string $recipientType;

    /**
     * @var string $taxId Employer identification number (EIN) or Social Security number (SSN).
     */
    #[JsonProperty('taxId')]
    public string $taxId;

    /**
     * @var ?string $charityId Government identifier of the charity.
     */
    #[JsonProperty('charityId')]
    public ?string $charityId;

    /**
     * @var string $doingBusinessAs Trading name of the business or organization.
     */
    #[JsonProperty('doingBusinessAs')]
    public string $doingBusinessAs;

    /**
     * @var Address $address Address of the funding recipient.
     */
    #[JsonProperty('address')]
    public Address $address;

    /**
     * @var array<ContactMethod> $contactMethods Array of contactMethod objects that you can use to add contact methods for the funding recipient. You must provide at least an email address.
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @var ?array<string, string> $metadata [Metadata](https://docs.payroc.com/api/metadata) object you can use to include custom data with your request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @var array<Owner> $owners Array of owner objects. Each object contains information about an individual who owns or manages the funding recipient.
     */
    #[JsonProperty('owners'), ArrayType([Owner::class])]
    public array $owners;

    /**
     * @var array<FundingAccount> $fundingAccounts Array of fundingAccount objects that you can use to add funding accounts to the funding recipient.
     */
    #[JsonProperty('fundingAccounts'), ArrayType([FundingAccount::class])]
    public array $fundingAccounts;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   recipientType: value-of<CreateFundingRecipientRecipientType>,
     *   taxId: string,
     *   doingBusinessAs: string,
     *   address: Address,
     *   contactMethods: array<ContactMethod>,
     *   owners: array<Owner>,
     *   fundingAccounts: array<FundingAccount>,
     *   charityId?: ?string,
     *   metadata?: ?array<string, string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->recipientType = $values['recipientType'];
        $this->taxId = $values['taxId'];
        $this->charityId = $values['charityId'] ?? null;
        $this->doingBusinessAs = $values['doingBusinessAs'];
        $this->address = $values['address'];
        $this->contactMethods = $values['contactMethods'];
        $this->metadata = $values['metadata'] ?? null;
        $this->owners = $values['owners'];
        $this->fundingAccounts = $values['fundingAccounts'];
    }
}
