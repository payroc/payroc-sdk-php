<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the owner's relationship to the business.
 */
class OwnerRelationship extends JsonSerializableType
{
    /**
     * @var ?float $equityPercentage Percentage equity stake that the owner holds in the business.
     */
    #[JsonProperty('equityPercentage')]
    public ?float $equityPercentage;

    /**
     * @var ?string $title Owner's job title.
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var bool $isControlProng Indicates if the owner is a control prong. You can identify only one control prong for a business.
     */
    #[JsonProperty('isControlProng')]
    public bool $isControlProng;

    /**
     * @var ?bool $isAuthorizedSignatory Indicates if the owner is an authorized signatory.
     */
    #[JsonProperty('isAuthorizedSignatory')]
    public ?bool $isAuthorizedSignatory;

    /**
     * @param array{
     *   isControlProng: bool,
     *   equityPercentage?: ?float,
     *   title?: ?string,
     *   isAuthorizedSignatory?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->equityPercentage = $values['equityPercentage'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->isControlProng = $values['isControlProng'];
        $this->isAuthorizedSignatory = $values['isAuthorizedSignatory'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
