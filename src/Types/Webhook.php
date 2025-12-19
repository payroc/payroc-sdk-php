<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class Webhook extends JsonSerializableType
{
    /**
     * @var string $uri Public endpoint that we send notifications to.
     */
    #[JsonProperty('uri')]
    public string $uri;

    /**
     * String that we send with a notification so that you can ensure it is a valid notification from our gateway. We include the value in the Payroc-Secret header parameter in the webhook call.
     * **Note:** In the response, we truncate the secret to the last 16 characters and mask the first 10 characters.
     *
     * @var string $secret
     */
    #[JsonProperty('secret')]
    public string $secret;

    /**
     * @var string $supportEmailAddress Email address of the person or team that we contact if we can't deliver notifications.
     */
    #[JsonProperty('supportEmailAddress')]
    public string $supportEmailAddress;

    /**
     * @param array{
     *   uri: string,
     *   secret: string,
     *   supportEmailAddress: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->uri = $values['uri'];
        $this->secret = $values['secret'];
        $this->supportEmailAddress = $values['supportEmailAddress'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
