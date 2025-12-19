<?php

namespace Payroc\PaymentLinks\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\PaymentLinks\Types\ListPaymentLinksRequestLinkType;
use Payroc\PaymentLinks\Types\ListPaymentLinksRequestChargeType;
use Payroc\PaymentLinks\Types\ListPaymentLinksRequestStatus;
use DateTime;

class ListPaymentLinksRequest extends JsonSerializableType
{
    /**
     * @var ?string $merchantReference Filter results by the unique identifier that the merchant assigned to the payment link.
     */
    public ?string $merchantReference;

    /**
     * @var ?value-of<ListPaymentLinksRequestLinkType> $linkType Filter results by the type of link. Send a value of <code>singleUse</code> or <code>multiUse</code>.
     */
    public ?string $linkType;

    /**
     * Filter results by the user that entered the amount. Send one of the following values:
     * - <code>prompt</code> - Customer entered the amount.
     * - <code>preset</code> - Merchant entered the amount.
     *
     * @var ?value-of<ListPaymentLinksRequestChargeType> $chargeType
     */
    public ?string $chargeType;

    /**
     * @var ?value-of<ListPaymentLinksRequestStatus> $status Filter results by the status of the payment link. Send a value of <code>active</code>, <code>completed</code>,<code>deactived</code>, or <code>expired</code>.
     */
    public ?string $status;

    /**
     * @var ?string $recipientName Filter results by the customer's name.
     */
    public ?string $recipientName;

    /**
     * @var ?string $recipientEmail Filter results by the customer's email address.
     */
    public ?string $recipientEmail;

    /**
     * @var ?DateTime $createdOn Filter results by the link's created date. Send a value in **YYYY-MM-DD** format.
     */
    public ?DateTime $createdOn;

    /**
     * @var ?DateTime $expiresOn Filter results by the link's expiry date. Send a value in **YYYY-MM-DD** format.
     */
    public ?DateTime $expiresOn;

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
     *   merchantReference?: ?string,
     *   linkType?: ?value-of<ListPaymentLinksRequestLinkType>,
     *   chargeType?: ?value-of<ListPaymentLinksRequestChargeType>,
     *   status?: ?value-of<ListPaymentLinksRequestStatus>,
     *   recipientName?: ?string,
     *   recipientEmail?: ?string,
     *   createdOn?: ?DateTime,
     *   expiresOn?: ?DateTime,
     *   before?: ?string,
     *   after?: ?string,
     *   limit?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->merchantReference = $values['merchantReference'] ?? null;
        $this->linkType = $values['linkType'] ?? null;
        $this->chargeType = $values['chargeType'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->recipientName = $values['recipientName'] ?? null;
        $this->recipientEmail = $values['recipientEmail'] ?? null;
        $this->createdOn = $values['createdOn'] ?? null;
        $this->expiresOn = $values['expiresOn'] ?? null;
        $this->before = $values['before'] ?? null;
        $this->after = $values['after'] ?? null;
        $this->limit = $values['limit'] ?? null;
    }
}
