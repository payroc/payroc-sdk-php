<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class MerchantPlatform extends JsonSerializableType
{
    /**
     * @var ?string $merchantPlatformId Unique identifier that we assigned to the merchant platform.
     */
    #[JsonProperty('merchantPlatformId')]
    public ?string $merchantPlatformId;

    /**
     * @var ?DateTime $createdDate Date that the merchant platform was created. We return this value in the [ISO-8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date that the merchant platform was last modified. We return this value in the [ISO-8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $lastModifiedDate;

    /**
     * @var Business $business
     */
    #[JsonProperty('business')]
    public Business $business;

    /**
     * @var ?array<MerchantPlatformProcessingAccountsItem> $processingAccounts Array of processingAccount objects.
     */
    #[JsonProperty('processingAccounts'), ArrayType([MerchantPlatformProcessingAccountsItem::class])]
    public ?array $processingAccounts;

    /**
     * @var ?array<string, string> $metadata Object that you can send to include custom metadata in the request.
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
     *   business: Business,
     *   merchantPlatformId?: ?string,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   processingAccounts?: ?array<MerchantPlatformProcessingAccountsItem>,
     *   metadata?: ?array<string, string>,
     *   links?: ?array<Link>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->merchantPlatformId = $values['merchantPlatformId'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->business = $values['business'];
        $this->processingAccounts = $values['processingAccounts'] ?? null;
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
