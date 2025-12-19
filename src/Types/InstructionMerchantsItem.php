<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Instruction indicating which recipients should receive funding from the specific merchant balance.
 */
class InstructionMerchantsItem extends JsonSerializableType
{
    /**
     * @var string $merchantId Unique identifier that the processor assigned to the merchant.
     */
    #[JsonProperty('merchantId')]
    public string $merchantId;

    /**
     * @var array<InstructionMerchantsItemRecipientsItem> $recipients Array of recipients objects. Each object contains information about the funding account and the amount of funds we send to the funding account.
     */
    #[JsonProperty('recipients'), ArrayType([InstructionMerchantsItemRecipientsItem::class])]
    public array $recipients;

    /**
     * @var ?InstructionMerchantsItemLink $link Object that contains HATEOAS links for the resource.
     */
    #[JsonProperty('link')]
    public ?InstructionMerchantsItemLink $link;

    /**
     * @param array{
     *   merchantId: string,
     *   recipients: array<InstructionMerchantsItemRecipientsItem>,
     *   link?: ?InstructionMerchantsItemLink,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->merchantId = $values['merchantId'];
        $this->recipients = $values['recipients'];
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
