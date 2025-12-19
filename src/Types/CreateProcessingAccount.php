<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;
use DateTime;
use Payroc\Core\Types\Date;

class CreateProcessingAccount extends JsonSerializableType
{
    /**
     * @var ?string $processingAccountId Unique identifier of the processing account.
     */
    #[JsonProperty('processingAccountId')]
    public ?string $processingAccountId;

    /**
     * @var string $doingBusinessAs Trading name of the business.
     */
    #[JsonProperty('doingBusinessAs')]
    public string $doingBusinessAs;

    /**
     * Collection of individuals that are responsible for a processing account. When you create a processing account, you must indicate at least one owner as either of the following:
     *
     * - **Control prong** - An individual who has a significant equity stake in the business and can make decisions for the processing account. You can add only one control prong to a processing account.
     * - **Authorized signatory** - An individual who doesn't have an equity stake in the business but can make decisions for the processing account.
     *
     * @var array<Owner> $owners
     */
    #[JsonProperty('owners'), ArrayType([Owner::class])]
    public array $owners;

    /**
     * @var ?string $website Website address of the business.
     */
    #[JsonProperty('website')]
    public ?string $website;

    /**
     * @var value-of<CreateProcessingAccountBusinessType> $businessType Type of business.
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
     * @var DateTime $businessStartDate Date that the business was established. The format of the value is **YYYY-MM-DD**.
     */
    #[JsonProperty('businessStartDate'), Date(Date::TYPE_DATE)]
    public DateTime $businessStartDate;

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
     * @var array<ContactMethod> $contactMethods Array of contactMethod objects. One contact method must be an email address.
     */
    #[JsonProperty('contactMethods'), ArrayType([ContactMethod::class])]
    public array $contactMethods;

    /**
     * @var Processing $processing
     */
    #[JsonProperty('processing')]
    public Processing $processing;

    /**
     * @var CreateFunding $funding
     */
    #[JsonProperty('funding')]
    public CreateFunding $funding;

    /**
     * @var Pricing $pricing
     */
    #[JsonProperty('pricing')]
    public Pricing $pricing;

    /**
     * @var Signature $signature
     */
    #[JsonProperty('signature')]
    public Signature $signature;

    /**
     * @var ?array<Contact> $contacts Array of contact objects.
     */
    #[JsonProperty('contacts'), ArrayType([Contact::class])]
    public ?array $contacts;

    /**
     * @var ?array<string, string> $metadata Object that you can send to include custom data in the request. For more information about how to use metadata, go to [Metadata](https://docs.payroc.com/api/metadata).
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @param array{
     *   doingBusinessAs: string,
     *   owners: array<Owner>,
     *   businessType: value-of<CreateProcessingAccountBusinessType>,
     *   categoryCode: int,
     *   merchandiseOrServiceSold: string,
     *   businessStartDate: DateTime,
     *   timezone: value-of<Timezone>,
     *   address: Address,
     *   contactMethods: array<ContactMethod>,
     *   processing: Processing,
     *   funding: CreateFunding,
     *   pricing: Pricing,
     *   signature: Signature,
     *   processingAccountId?: ?string,
     *   website?: ?string,
     *   contacts?: ?array<Contact>,
     *   metadata?: ?array<string, string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingAccountId = $values['processingAccountId'] ?? null;
        $this->doingBusinessAs = $values['doingBusinessAs'];
        $this->owners = $values['owners'];
        $this->website = $values['website'] ?? null;
        $this->businessType = $values['businessType'];
        $this->categoryCode = $values['categoryCode'];
        $this->merchandiseOrServiceSold = $values['merchandiseOrServiceSold'];
        $this->businessStartDate = $values['businessStartDate'];
        $this->timezone = $values['timezone'];
        $this->address = $values['address'];
        $this->contactMethods = $values['contactMethods'];
        $this->processing = $values['processing'];
        $this->funding = $values['funding'];
        $this->pricing = $values['pricing'];
        $this->signature = $values['signature'];
        $this->contacts = $values['contacts'] ?? null;
        $this->metadata = $values['metadata'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
