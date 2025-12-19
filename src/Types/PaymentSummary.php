<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about a payment.
 */
class PaymentSummary extends JsonSerializableType
{
    /**
     * @var string $paymentId Unique identifier of the payment.
     */
    #[JsonProperty('paymentId')]
    public string $paymentId;

    /**
     * @var DateTime $dateTime Date and time that the payment was processed.
     */
    #[JsonProperty('dateTime'), Date(Date::TYPE_DATETIME)]
    public DateTime $dateTime;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * @var int $amount Amount of the payment. This value is in the currency’s lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public int $amount;

    /**
     * @var value-of<PaymentSummaryStatus> $status Current status of the payment.
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
     * @var value-of<PaymentSummaryResponseCode> $responseCode
     */
    #[JsonProperty('responseCode')]
    public string $responseCode;

    /**
     * @var string $responseMessage Response description from the processor.
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
     *   paymentId: string,
     *   dateTime: DateTime,
     *   currency: value-of<Currency>,
     *   amount: int,
     *   status: value-of<PaymentSummaryStatus>,
     *   responseCode: value-of<PaymentSummaryResponseCode>,
     *   responseMessage: string,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentId = $values['paymentId'];
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
