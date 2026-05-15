<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

class ClosedLoopResponse extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var string $closedLoopReadId Unique identifier that we assigned to the closed-loop read.
     */
    #[JsonProperty('closedLoopReadId')]
    public string $closedLoopReadId;

    /**
     * @var DateTime $readDate Date that the payment device read the closed-loop card. Our gateway returns this value in **YYYY-MM-DD** format.
     */
    #[JsonProperty('readDate'), Date(Date::TYPE_DATE)]
    public DateTime $readDate;

    /**
     * @var array<string, mixed> $data Unstructured payload from the card.
     */
    #[JsonProperty('data'), ArrayType(['string' => 'mixed'])]
    public array $data;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   closedLoopReadId: string,
     *   readDate: DateTime,
     *   data: array<string, mixed>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->closedLoopReadId = $values['closedLoopReadId'];
        $this->readDate = $values['readDate'];
        $this->data = $values['data'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
