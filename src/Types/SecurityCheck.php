<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about card verification and security checks.
 */
class SecurityCheck extends JsonSerializableType
{
    /**
     * Indicates if the card verification value (CVV) that the customer provided in the request matches the CVV on the card.
     * - `M` – The CVV matches the card’s CVV.
     * - `N` – The CVV doesn’t match the card’s CVV.
     * - `P` – The CVV wasn’t processed.
     * - `U` – The CVV isn’t registered.
     *
     * **Note:** Our gateway doesn’t automatically decline transactions when the CVV doesn’t match the card’s CVV, unless the merchant selects this setting in their account.
     *
     * @var ?value-of<SecurityCheckCvvResult> $cvvResult
     */
    #[JsonProperty('cvvResult')]
    public ?string $cvvResult;

    /**
     * Indicates if the address that the customer provided in the request matches the address linked to the card.
     *
     * - `Y` – The address in the request matches the address linked to the card.
     * - `N` – The address in the request doesn’t match the address linked to the card.
     * - `A` – The street address matches, but ZIP code or postal code doesn’t match.
     * - `Z` - The ZIP code or postal code matches, but street address doesn’t match.
     * - `U` – The address information is unavailable.
     * - `G` – The issuer or card brand doesn’t support the Address Verification Service (AVS).
     * - `R` – The AVS is currently unavailable. Try again later.
     * - `S` – There was no AVS data in the request, or it was sent in the wrong format.
     * - `F` - For UK addresses, the address in the request matches the address linked to the card.
     * - `W` – For US addresses, the nine-digit ZIP code or postal code in the request matches the address linked to the card but the street address doesn’t.
     * - `X` – For US addresses, the nine-digit ZIP code or postal code and the street address matches the address linked to the card.
     *
     * **Note:** Our gateway doesn’t automatically decline transactions when the address doesn’t match the address linked to the card,
     * unless the merchant selects this setting in their account.
     *
     * @var ?value-of<SecurityCheckAvsResult> $avsResult
     */
    #[JsonProperty('avsResult')]
    public ?string $avsResult;

    /**
     * @param array{
     *   cvvResult?: ?value-of<SecurityCheckCvvResult>,
     *   avsResult?: ?value-of<SecurityCheckAvsResult>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->cvvResult = $values['cvvResult'] ?? null;
        $this->avsResult = $values['avsResult'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
