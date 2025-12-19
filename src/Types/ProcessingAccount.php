<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;
use Payroc\Funding\Types\Funding;

class ProcessingAccount extends JsonSerializableType
{
    /**
     * @var ?string $processingAccountId Unique identifier of the processing account.
     */
    #[JsonProperty('processingAccountId')]
    public ?string $processingAccountId;

    /**
     * @var ?DateTime $createdDate Date and time that we received your request to create the processing account in our system.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date and time that the processing account was last modified.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $lastModifiedDate;

    /**
     * Status of the processing account.
     * - `entered` - We have received information about the account, but we have not yet reviewed it.
     * - `pending` - We have reviewed the information about the account, but we have not yet approved it.
     * - `approved` - We have approved the account for processing transactions and funding.
     * - `subjectTo` - We have approved the account, but we are waiting on further information.
     * - `dormant` - Account is closed for a period.
     * - `nonProcessing` - We have approved the account, but the merchant has not yet run a transaction.
     * - `rejected` - We rejected the application for the processing account.
     * - `terminated` - Processing account is closed.
     * - `cancelled` - Merchant withdrew the application for the processing account.
     * **Note**: You can subscribe to our processingAccount.status.changed event to get notifications when we change the status of a processing account. For more information about how to subscribe to events, go to [Event Subscriptions](https://docs.payroc.com/guides/integrate/event-subscriptions).
     *
     * @var ?value-of<ProcessingAccountStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var string $doingBusinessAs Trading name of the business.
     */
    #[JsonProperty('doingBusinessAs')]
    public string $doingBusinessAs;

    /**
     * @var ?array<ProcessingAccountOwnersItem> $owners Object that contains information about the owners of the business.
     */
    #[JsonProperty('owners'), ArrayType([ProcessingAccountOwnersItem::class])]
    public ?array $owners;

    /**
     * @var ?string $website Website address of the business.
     */
    #[JsonProperty('website')]
    public ?string $website;

    /**
     * @var value-of<ProcessingAccountBusinessType> $businessType Type of business.
     */
    #[JsonProperty('businessType')]
    public string $businessType;

    /**
     * @var int $categoryCode Merchant Category Code (MCC) for the type of business.
     */
    #[JsonProperty('categoryCode')]
    public int $categoryCode;

    /**
     * @var string $merchandiseOrServiceSold Description of the services or merchandise sold by the business.
     */
    #[JsonProperty('merchandiseOrServiceSold')]
    public string $merchandiseOrServiceSold;

    /**
     * @var ?DateTime $businessStartDate Date that the business was established. The format of the value is **YYYY-MM-DD**.
     */
    #[JsonProperty('businessStartDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $businessStartDate;

    /**
     * @var value-of<Timezone> $timezone
     */
    #[JsonProperty('timezone')]
    public string $timezone;

    /**
     * @var Address $address
     */
    #[JsonProperty('address')]
    public Address $address;

    /**
     * @var array<ContactMethod> $contactMethods Array of contactMethods objects for the processing account. At least one contactMethod must be an email address.
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @var Processing $processing
     */
    #[JsonProperty('processing')]
    public Processing $processing;

    /**
     * @var Funding $funding
     */
    #[JsonProperty('funding')]
    public Funding $funding;

    /**
     * @var ProcessingAccountPricing $pricing Object that HATEOAS links to the pricing information that we apply to the processing account.
     */
    #[JsonProperty('pricing')]
    public ProcessingAccountPricing $pricing;

    /**
     * @var ?array<ProcessingAccountContactsItem> $contacts Array of contact objects.
     */
    #[JsonProperty('contacts'), ArrayType([ProcessingAccountContactsItem::class])]
    public ?array $contacts;

    /**
     * @var Signature $signature
     */
    #[JsonProperty('signature')]
    public Signature $signature;

    /**
     * @var ?array<string, string> $metadata Object that you can send to include custom data in the request. For more information about how to use metadata, go to [Metadata](https://docs.payroc.com/api/metadata).
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @var ?array<Link> $links Array of useful links related to your request.
     */
    #[JsonProperty('links'), ArrayType([Link::class])]
    public ?array $links;

    /**
     * @param array{
     *   doingBusinessAs: string,
     *   businessType: value-of<ProcessingAccountBusinessType>,
     *   categoryCode: int,
     *   merchandiseOrServiceSold: string,
     *   timezone: value-of<Timezone>,
     *   address: Address,
     *   contactMethods: array<ContactMethod>,
     *   processing: Processing,
     *   funding: Funding,
     *   pricing: ProcessingAccountPricing,
     *   signature: Signature,
     *   processingAccountId?: ?string,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   status?: ?value-of<ProcessingAccountStatus>,
     *   owners?: ?array<ProcessingAccountOwnersItem>,
     *   website?: ?string,
     *   businessStartDate?: ?DateTime,
     *   contacts?: ?array<ProcessingAccountContactsItem>,
     *   metadata?: ?array<string, string>,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingAccountId = $values['processingAccountId'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->doingBusinessAs = $values['doingBusinessAs'];
        $this->owners = $values['owners'] ?? null;
        $this->website = $values['website'] ?? null;
        $this->businessType = $values['businessType'];
        $this->categoryCode = $values['categoryCode'];
        $this->merchandiseOrServiceSold = $values['merchandiseOrServiceSold'];
        $this->businessStartDate = $values['businessStartDate'] ?? null;
        $this->timezone = $values['timezone'];
        $this->address = $values['address'];
        $this->contactMethods = $values['contactMethods'];
        $this->processing = $values['processing'];
        $this->funding = $values['funding'];
        $this->pricing = $values['pricing'];
        $this->contacts = $values['contacts'] ?? null;
        $this->signature = $values['signature'];
        $this->metadata = $values['metadata'] ?? null;
        $this->links = $values['links'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
