<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the terminal's host configuration.
 */
class HostConfiguration extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that our gateway assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $processingAccountId Unique identifier that we assigned to the processing account.
     */
    #[JsonProperty('processingAccountId')]
    public ?string $processingAccountId;

    /**
     * @var HostConfigurationConfiguration $configuration Object that contains the host processor configuration.
     */
    #[JsonProperty('configuration')]
    public HostConfigurationConfiguration $configuration;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   configuration: HostConfigurationConfiguration,
     *   processingAccountId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->processingAccountId = $values['processingAccountId'] ?? null;
        $this->configuration = $values['configuration'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
