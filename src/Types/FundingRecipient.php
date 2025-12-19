<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class FundingRecipient extends JsonSerializableType
{
    /**
     * @var ?int $recipientId Unique identifier that we assigned to the funding recipient.
     */
    #[JsonProperty('recipientId')]
    public ?int $recipientId;

    /**
     * @var ?value-of<FundingRecipientStatus> $status Indicates if we have approved the funding recipient.
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?DateTime $createdDate Date the funding recipient was created.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date the funding recipient was last modified.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $lastModifiedDate;

    /**
     * @var value-of<FundingRecipientRecipientType> $recipientType Type or legal structure of the funding recipient.
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
     * @var string $doingBusinessAs Legal name of the business or organization.
     */
    #[JsonProperty('doingBusinessAs')]
    public string $doingBusinessAs;

    /**
     * @var Address $address Address of the funding recipient.
     */
    #[JsonProperty('address')]
    public Address $address;

    /**
     * @var array<ContactMethod> $contactMethods Array of contactMethod objects for the funding recipient.
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @var ?array<string, string> $metadata [Metadata](https://docs.payroc.com/api/metadata) object you can use to include custom data with your request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @var ?array<FundingRecipientOwnersItem> $owners Array of owner objects associated with the funding recipient.
     */
    #[JsonProperty('owners'), ArrayType([FundingRecipientOwnersItem::class])]
    public ?array $owners;

    /**
     * @var ?array<FundingRecipientFundingAccountsItem> $fundingAccounts Array of fundingAccount objects associated with the funding recipient.
     */
    #[JsonProperty('fundingAccounts'), ArrayType([FundingRecipientFundingAccountsItem::class])]
    public ?array $fundingAccounts;

    /**
     * @param array{
     *   recipientType: value-of<FundingRecipientRecipientType>,
     *   taxId: string,
     *   doingBusinessAs: string,
     *   address: Address,
     *   contactMethods: array<ContactMethod>,
     *   recipientId?: ?int,
     *   status?: ?value-of<FundingRecipientStatus>,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   charityId?: ?string,
     *   metadata?: ?array<string, string>,
     *   owners?: ?array<FundingRecipientOwnersItem>,
     *   fundingAccounts?: ?array<FundingRecipientFundingAccountsItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->recipientId = $values['recipientId'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->recipientType = $values['recipientType'];
        $this->taxId = $values['taxId'];
        $this->charityId = $values['charityId'] ?? null;
        $this->doingBusinessAs = $values['doingBusinessAs'];
        $this->address = $values['address'];
        $this->contactMethods = $values['contactMethods'];
        $this->metadata = $values['metadata'] ?? null;
        $this->owners = $values['owners'] ?? null;
        $this->fundingAccounts = $values['fundingAccounts'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
