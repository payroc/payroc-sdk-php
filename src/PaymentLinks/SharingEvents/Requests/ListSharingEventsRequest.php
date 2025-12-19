<?php

namespace Payroc\PaymentLinks\SharingEvents\Requests;

use Payroc\Core\Json\JsonSerializableType;

class ListSharingEventsRequest extends JsonSerializableType
{
    /**
     * @var ?string $recipientName Filter results by the customer's name.
     */
    public ?string $recipientName;

    /**
     * @var ?string $recipientEmail Filter results by the customer's email address.
     */
    public ?string $recipientEmail;

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
     *   recipientName?: ?string,
     *   recipientEmail?: ?string,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->recipientName = $values['recipientName'] ?? null;
        $this->recipientEmail = $values['recipientEmail'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
