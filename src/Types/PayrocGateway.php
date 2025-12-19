<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the gateway settings for the solution.
 */
class PayrocGateway extends JsonSerializableType
{
    /**
     * @var value-of<PayrocGatewayGateway> $gateway Name of the gateway that processes the transactions.
     */
    #[JsonProperty('gateway')]
    public string $gateway;

    /**
     * @var string $terminalTemplateId Unique identifier of the gateway terminal template.
     */
    #[JsonProperty('terminalTemplateId')]
    public string $terminalTemplateId;

    /**
     * @param array{
     *   gateway: value-of<PayrocGatewayGateway>,
     *   terminalTemplateId: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->gateway = $values['gateway'];
        $this->terminalTemplateId = $values['terminalTemplateId'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
