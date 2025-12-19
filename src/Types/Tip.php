<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the tip.
 */
class Tip extends JsonSerializableType
{
    /**
     * Indicates if the tip is a fixed amount or a percentage.
     * **Note:** Our gateway applies the percentage tip to the total amount of the transaction after tax.
     *
     * @var value-of<TipType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * Indicates how the tip was added to the transaction.
     * - `prompted` – The customer was prompted to add a tip during payment.
     * - `adjusted` – The customer added a tip on the receipt for the merchant to adjust post-transaction.
     *
     * @var ?value-of<TipMode> $mode
     */
    #[JsonProperty('mode')]
    public ?string $mode;

    /**
     * @var ?int $amount If the value for type is `fixedAmount`, this value is the tip amount in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('amount')]
    public ?int $amount;

    /**
     * @var ?float $percentage If the value for type is `percentage`, this value is the tip as a percentage.
     */
    #[JsonProperty('percentage')]
    public ?float $percentage;

    /**
     * @param array{
     *   type: value-of<TipType>,
     *   mode?: ?value-of<TipMode>,
     *   amount?: ?int,
     *   percentage?: ?float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->mode = $values['mode'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->percentage = $values['percentage'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
