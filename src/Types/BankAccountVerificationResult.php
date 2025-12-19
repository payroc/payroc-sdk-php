<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class BankAccountVerificationResult extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * Indicates if the customer's bank account details are valid.
     * - `true` - Account details are valid.
     * - `false` - Account details are not valid.
     *
     * @var bool $verified
     */
    #[JsonProperty('verified')]
    public bool $verified;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   verified: bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->verified = $values['verified'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
