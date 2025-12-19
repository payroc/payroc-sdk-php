<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

class HostedFieldsCreateSessionResponse extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * Token that our gateway assigned to the Hosted Fields session.
     *
     * Include this session token in the config file for Hosted Fields.
     *
     * The session token expires after 10 minutes.
     *
     * @var string $token
     */
    #[JsonProperty('token')]
    public string $token;

    /**
     * @var ?DateTime $expiresAt Date and time that the token expires. We return this value in the [ISO 8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('expiresAt'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $expiresAt;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   token: string,
     *   expiresAt?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->token = $values['token'];
        $this->expiresAt = $values['expiresAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
