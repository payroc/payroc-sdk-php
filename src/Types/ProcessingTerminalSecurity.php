<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the tokenization settings and AVS settings for the terminal.
 */
class ProcessingTerminalSecurity extends JsonSerializableType
{
    /**
     * @var bool $tokenization Indicates if the terminal can tokenize customer's payment details. For more information about tokenization, go to [Tokenization](https://docs.payroc.com/knowledge/basic-concepts/tokenization).
     */
    #[JsonProperty('tokenization')]
    public bool $tokenization;

    /**
     * @var bool $avsPrompt Indicates if the terminal should prompt for Address Verification Service (AVS) details when running a transaction.
     */
    #[JsonProperty('avsPrompt')]
    public bool $avsPrompt;

    /**
     * @var ?value-of<ProcessingTerminalSecurityAvsLevel> $avsLevel Indicates the level of AVS details that the terminal should prompt for.
     */
    #[JsonProperty('avsLevel')]
    public ?string $avsLevel;

    /**
     * @var bool $cvvPrompt Indicates if the terminal should prompt for a Card Verfication Value (CVV) when running a transaction.
     */
    #[JsonProperty('cvvPrompt')]
    public bool $cvvPrompt;

    /**
     * @param array{
     *   tokenization: bool,
     *   avsPrompt: bool,
     *   cvvPrompt: bool,
     *   avsLevel?: ?value-of<ProcessingTerminalSecurityAvsLevel>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->tokenization = $values['tokenization'];
        $this->avsPrompt = $values['avsPrompt'];
        $this->avsLevel = $values['avsLevel'] ?? null;
        $this->cvvPrompt = $values['cvvPrompt'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
