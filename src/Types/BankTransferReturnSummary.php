<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about a return.
 */
class BankTransferReturnSummary extends JsonSerializableType
{
    /**
     * @var string $paymentId Unique identifier that our gateway assigned to the payment.
     */
    #[JsonProperty('paymentId')]
    public string $paymentId;

    /**
     * @var DateTime $date The date that the check was returned.
     */
    #[JsonProperty('date'), Date(Date::TYPE_DATE)]
    public DateTime $date;

    /**
     * @var string $returnCode The NACHA return code.
     */
    #[JsonProperty('returnCode')]
    public string $returnCode;

    /**
     * @var string $returnReason The reason why the check was returned.
     */
    #[JsonProperty('returnReason')]
    public string $returnReason;

    /**
     * @var bool $represented Indicates whether the return has been re-presented.
     */
    #[JsonProperty('represented')]
    public bool $represented;

    /**
     * @var ?Link $link
     */
    #[JsonProperty('link')]
    public ?Link $link;

    /**
     * @param array{
     *   paymentId: string,
     *   date: DateTime,
     *   returnCode: string,
     *   returnReason: string,
     *   represented: bool,
     *   link?: ?Link,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentId = $values['paymentId'];
        $this->date = $values['date'];
        $this->returnCode = $values['returnCode'];
        $this->returnReason = $values['returnReason'];
        $this->represented = $values['represented'];
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
