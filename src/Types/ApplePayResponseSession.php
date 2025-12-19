<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class ApplePayResponseSession extends JsonSerializableType
{
    /**
     * Object that Apple returns when they start the merchant's Apple Pay session.
     *
     * Send the content in this object to Apple to retrieve the cardholder's encrypted payment details.
     *
     * @var string $startSessionResponse
     */
    #[JsonProperty('startSessionResponse')]
    public string $startSessionResponse;

    /**
     * @param array{
     *   startSessionResponse: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->startSessionResponse = $values['startSessionResponse'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
