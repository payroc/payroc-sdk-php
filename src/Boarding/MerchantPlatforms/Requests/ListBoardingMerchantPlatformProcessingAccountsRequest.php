<?php

namespace Payroc\Boarding\MerchantPlatforms\Requests;

use Payroc\Core\Json\JsonSerializableType;

class ListBoardingMerchantPlatformProcessingAccountsRequest extends JsonSerializableType
{
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
     * Indicates if you want to return closed processing accounts. This includes processing accounts that have a status of `terminated`, `cancelled`, or `rejected`.
     * **Note**: By default, we return only open processing accounts.
     *
     * @var ?bool $includeClosed
     */
    public ?bool $includeClosed;

    /**
     * @param array{
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     *   includeClosed?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->includeClosed = $values['includeClosed'] ?? null;
    }
}
