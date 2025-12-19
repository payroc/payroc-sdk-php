<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the gateway settings for the solution.
 */
class OrderItemSolutionSetupGatewaySettings extends JsonSerializableType
{
    /**
     * @var ?string $merchantPortfolioId Unique identifier of the merchant portfolio.
     */
    #[JsonProperty('merchantPortfolioId')]
    public ?string $merchantPortfolioId;

    /**
     * @var ?string $merchantTemplateId Unique identifier of the gateway merchant template.
     */
    #[JsonProperty('merchantTemplateId')]
    public ?string $merchantTemplateId;

    /**
     * @var ?string $userTemplateId Unique identifier of the gateway user template.
     */
    #[JsonProperty('userTemplateId')]
    public ?string $userTemplateId;

    /**
     * @var ?string $terminalTemplateId Unique identifier of the gateway terminal template.
     */
    #[JsonProperty('terminalTemplateId')]
    public ?string $terminalTemplateId;

    /**
     * @param array{
     *   merchantPortfolioId?: ?string,
     *   merchantTemplateId?: ?string,
     *   userTemplateId?: ?string,
     *   terminalTemplateId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->merchantPortfolioId = $values['merchantPortfolioId'] ?? null;
        $this->merchantTemplateId = $values['merchantTemplateId'] ?? null;
        $this->userTemplateId = $values['userTemplateId'] ?? null;
        $this->terminalTemplateId = $values['terminalTemplateId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
