<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the types of cards that the processing account accepts.
 */
class ProcessingCardAcceptance extends JsonSerializableType
{
    /**
     * @var ?bool $debitOnly Indicates if the merchant accepts only debit cards.
     */
    #[JsonProperty('debitOnly')]
    public ?bool $debitOnly;

    /**
     * @var ?bool $hsaFsa Indicates if the merchant accepts health savings account (HSA) and flexible spending account (FSA) cards.
     */
    #[JsonProperty('hsaFsa')]
    public ?bool $hsaFsa;

    /**
     * @var ?array<value-of<ProcessingCardAcceptanceCardsAcceptedItem>> $cardsAccepted List of card types the merchant accepts.
     */
    #[JsonProperty('cardsAccepted'), ArrayType(['string'])]
    public ?array $cardsAccepted;

    /**
     * @var ?ProcessingCardAcceptanceSpecialityCards $specialityCards Information about the speciality cards that the merchant accepts.
     */
    #[JsonProperty('specialityCards')]
    public ?ProcessingCardAcceptanceSpecialityCards $specialityCards;

    /**
     * @param array{
     *   debitOnly?: ?bool,
     *   hsaFsa?: ?bool,
     *   cardsAccepted?: ?array<value-of<ProcessingCardAcceptanceCardsAcceptedItem>>,
     *   specialityCards?: ?ProcessingCardAcceptanceSpecialityCards,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->debitOnly = $values['debitOnly'] ?? null;
        $this->hsaFsa = $values['hsaFsa'] ?? null;
        $this->cardsAccepted = $values['cardsAccepted'] ?? null;
        $this->specialityCards = $values['specialityCards'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
