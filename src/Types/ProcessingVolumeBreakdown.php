<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the types of transactions ran by the processing account. The percentages for transaction types must total 100%.
 */
class ProcessingVolumeBreakdown extends JsonSerializableType
{
    /**
     * @var int $cardPresent Estimated percentage of card-present transactions.
     */
    #[JsonProperty('cardPresent')]
    public int $cardPresent;

    /**
     * @var int $mailOrTelephone Estimated percentage of mail order or telephone transactions.
     */
    #[JsonProperty('mailOrTelephone')]
    public int $mailOrTelephone;

    /**
     * @var int $ecommerce Estimated percentage of e-Commerce transactions.
     */
    #[JsonProperty('ecommerce')]
    public int $ecommerce;

    /**
     * @param array{
     *   cardPresent: int,
     *   mailOrTelephone: int,
     *   ecommerce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->cardPresent = $values['cardPresent'];
        $this->mailOrTelephone = $values['mailOrTelephone'];
        $this->ecommerce = $values['ecommerce'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
