<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class FundingAccount extends JsonSerializableType
{
    /**
     * @var ?int $fundingAccountId Unique identifier that we assigned to the funding account.
     */
    #[JsonProperty('fundingAccountId')]
    public ?int $fundingAccountId;

    /**
     * @var ?DateTime $createdDate Date and time that we received your request to create the funding account in our system.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date and time that the funding account was last modified.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $lastModifiedDate;

    /**
     * Status of the funding account. The value is one of the following:
     * - `approved` - We approved the funding account.
     * - `rejected` - We rejected the funding account.
     * - `pending` - We have not yet approved the funding account.
     * - `hold` - Our Risk team have temporarily placed a hold on the funding account.
     *
     * @var ?value-of<FundingAccountStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var value-of<FundingAccountType> $type Type of funding account.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * Indicates if we send funds or withdraw funds from the account.
     * - `credit` - Send funds to the account.
     * - `debit` - Withdraw funds from the account.
     * - `creditAndDebit` - Send funds and withdraw funds from the account.
     *
     * **Note:** If the funding account is associated with a funding recipient, we accept only a value of `credit`.
     *
     * @var value-of<FundingAccountUse> $use
     */
    #[JsonProperty('use')]
    public string $use;

    /**
     * @var string $nameOnAccount Name of the account holder.
     */
    #[JsonProperty('nameOnAccount')]
    public string $nameOnAccount;

    /**
     * @var array<PaymentMethodsItem> $paymentMethods Array of paymentMethod objects.
     */
    #[JsonProperty('paymentMethods'), ArrayType([PaymentMethodsItem::class])]
    public array $paymentMethods;

    /**
     * @var ?array<string, string> $metadata [Metadata](https://docs.payroc.com/api/metadata) object you can use to include custom data with your request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @var ?array<Link> $links Array of HATEOAS links.
     */
    #[JsonProperty('links'), ArrayType([Link::class])]
    public ?array $links;

    /**
     * @param array{
     *   type: value-of<FundingAccountType>,
     *   use: value-of<FundingAccountUse>,
     *   nameOnAccount: string,
     *   paymentMethods: array<PaymentMethodsItem>,
     *   fundingAccountId?: ?int,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   status?: ?value-of<FundingAccountStatus>,
     *   metadata?: ?array<string, string>,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fundingAccountId = $values['fundingAccountId'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->type = $values['type'];
        $this->use = $values['use'];
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->paymentMethods = $values['paymentMethods'];
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
