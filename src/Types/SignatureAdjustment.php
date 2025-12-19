<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the signature for the transaction.
 * **Note:** If the merchant previously added a signature to the transaction, they can’t adjust or delete the signature.
 */
class SignatureAdjustment extends JsonSerializableType
{
    /**
     * @var string $cardholderSignature Cardholder’s signature. For more information about the format of the signature, see Special Fields and Parameters.
     */
    #[JsonProperty('cardholderSignature')]
    public string $cardholderSignature;

    /**
     * @param array{
     *   cardholderSignature: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->cardholderSignature = $values['cardholderSignature'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
