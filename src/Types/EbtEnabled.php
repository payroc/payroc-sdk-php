<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains details about EBT transactions.
 */
class EbtEnabled extends JsonSerializableType
{
    /**
     * @var bool $enabled Indicates if the terminal accepts Electronic Benefit Transfer (EBT) transactions.
     */
    #[JsonProperty('enabled')]
    public bool $enabled;

    /**
     * @var value-of<EbtEnabledEbtType> $ebtType Indicates the type of EBT that the terminal supports.
     */
    #[JsonProperty('ebtType')]
    public string $ebtType;

    /**
     * @var ?string $fnsNumber Food and Nutritional Service (FNS) number that the government assigns to the merchant to allow them to accept Supplemental Nutrition Assistance Program (SNAP) transactions.
     */
    #[JsonProperty('fnsNumber')]
    public ?string $fnsNumber;

    /**
     * @param array{
     *   enabled: bool,
     *   ebtType: value-of<EbtEnabledEbtType>,
     *   fnsNumber?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->enabled = $values['enabled'];
        $this->ebtType = $values['ebtType'];
        $this->fnsNumber = $values['fnsNumber'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
