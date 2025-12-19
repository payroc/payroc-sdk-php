<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class Tsys extends JsonSerializableType
{
    /**
     * @var TsysMerchant $merchant Object that contains the configuration settings for the merchant.
     */
    #[JsonProperty('merchant')]
    public TsysMerchant $merchant;

    /**
     * @var TsysTerminal $terminal Object that contains the configuration settings for the terminal.
     */
    #[JsonProperty('terminal')]
    public TsysTerminal $terminal;

    /**
     * @param array{
     *   merchant: TsysMerchant,
     *   terminal: TsysTerminal,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->merchant = $values['merchant'];
        $this->terminal = $values['terminal'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
