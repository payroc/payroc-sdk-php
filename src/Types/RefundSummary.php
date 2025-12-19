<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about a refund.
 */
class RefundSummary extends JsonSerializableType
{
    /**
     * @var string $refundId Unique identifier of the refund.
     */
    #[JsonProperty('refundId')]
    public string $refundId;

    /**
     * @var DateTime $dateTime Date and time that the refund was processed.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public DateTime $dateTime;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * @var int $amount Amount of the refund. This value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var value-of<RefundSummaryStatus> $status Current status of the refund.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * Response from the processor.
     * - `A` - The processor approved the transaction.
     * - `D` - The processor declined the transaction.
     * - `E` - The processor received the transaction but will process the transaction later.
     * - `P` - The processor authorized a portion of the original amount of the transaction.
     * - `R` - The issuer declined the transaction and indicated that the customer should contact their bank.
     * - `C` - The issuer declined the transaction and indicated that the merchant should keep the card as it was reported lost or stolen.
     *
     * @var value-of<RefundSummaryResponseCode> $responseCode
     */
    #[JsonProperty('responseCode')]
    public string $responseCode;

    /**
     * @var string $responseMessage Description of the response from the processor.
     */
    #[JsonProperty('responseMessage')]
    public string $responseMessage;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   refundId: string,
     *   dateTime: DateTime,
     *   currency: value-of<Currency>,
     *   amount: int,
     *   status: value-of<RefundSummaryStatus>,
     *   responseCode: value-of<RefundSummaryResponseCode>,
     *   responseMessage: string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->refundId = $values['refundId'];
        $this->dateTime = $values['dateTime'];
        $this->currency = $values['currency'];
        $this->amount = $values['amount'];
        $this->status = $values['status'];
        $this->responseCode = $values['responseCode'];
        $this->responseMessage = $values['responseMessage'];
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
