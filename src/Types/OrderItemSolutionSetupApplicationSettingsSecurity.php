<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the password settings when running specific transaction types.
 */
class OrderItemSolutionSetupApplicationSettingsSecurity extends JsonSerializableType
{
    /**
     * @var ?bool $refundPassword Indicates if the terminal should prompt the clerk for a password when running a refund.
     */
    #[JsonProperty('refundPassword')]
    public ?bool $refundPassword;

    /**
     * @var ?bool $keyedSalePassword Indicates if the terminal should prompt the clerk for a password when running a keyed sale.
     */
    #[JsonProperty('keyedSalePassword')]
    public ?bool $keyedSalePassword;

    /**
     * @var ?bool $reversalPassword Indicates if the terminal should prompt the clerk for a password when cancelling a transaction.
     */
    #[JsonProperty('reversalPassword')]
    public ?bool $reversalPassword;

    /**
     * @param array{
     *   refundPassword?: ?bool,
     *   keyedSalePassword?: ?bool,
     *   reversalPassword?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->refundPassword = $values['refundPassword'] ?? null;
        $this->keyedSalePassword = $values['keyedSalePassword'] ?? null;
        $this->reversalPassword = $values['reversalPassword'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
