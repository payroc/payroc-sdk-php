<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class MerchantPlatformProcessingAccountsItem extends JsonSerializableType
{
    /**
     * @var ?string $processingAccountId Unique identifier that we assigned to the processing account.
     */
    #[JsonProperty('processingAccountId')]
    public ?string $processingAccountId;

    /**
     * @var string $doingBusinessAs Trading name of the business.
     */
    #[JsonProperty('doingBusinessAs')]
    public string $doingBusinessAs;

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
     * - `failed` - An error occurred while we were setting up the processing account.
     *
     * **Note**: You can subscribe to our processingAccount.status.changed event to get notifications when we change the status of a processing account. For more information about how to subscribe to events, go to [Event Subscriptions](https://docs.payroc.com/guides/integrate/event-subscriptions).
     *
     * @var ?value-of<MerchantPlatformProcessingAccountsItemStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?MerchantPlatformProcessingAccountsItemLink $link Object that contains HATEOAS links for the processing account.
     */
    #[JsonProperty('link')]
    public ?MerchantPlatformProcessingAccountsItemLink $link;

    /**
     * @var ?Signature $signature
     */
    #[JsonProperty('signature')]
    public ?Signature $signature;

    /**
     * @param array{
     *   doingBusinessAs: string,
     *   processingAccountId?: ?string,
     *   status?: ?value-of<MerchantPlatformProcessingAccountsItemStatus>,
     *   link?: ?MerchantPlatformProcessingAccountsItemLink,
     *   signature?: ?Signature,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingAccountId = $values['processingAccountId'] ?? null;
        $this->doingBusinessAs = $values['doingBusinessAs'];
        $this->status = $values['status'] ?? null;
        $this->link = $values['link'] ?? null;
        $this->signature = $values['signature'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
