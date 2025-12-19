<?php

namespace Payroc\Tokenization\SingleUseTokens\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Tokenization\SingleUseTokens\Types\SingleUseTokenRequestChannel;
use Payroc\Core\Json\JsonProperty;
use Payroc\Tokenization\SingleUseTokens\Types\SingleUseTokenRequestSource;

class SingleUseTokenRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var value-of<SingleUseTokenRequestChannel> $channel Channel that the merchant used to receive the payment details.
     */
    #[JsonProperty('channel')]
    public string $channel;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var SingleUseTokenRequestSource $source Object that contains information about the payment method to tokenize.
     */
    #[JsonProperty('source')]
    public SingleUseTokenRequestSource $source;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   channel: value-of<SingleUseTokenRequestChannel>,
     *   source: SingleUseTokenRequestSource,
     *   operator?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->channel = $values['channel'];
        $this->operator = $values['operator'] ?? null;
        $this->source = $values['source'];
    }
}
