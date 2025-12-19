<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains information about the processing terminal.
 */
class ProcessingTerminalSummary extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the processing terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ProcessingTerminalSummaryLink $link Array of links related to your request. For more information about HATEOAS, go to [Hypermedia as the engine of application state](https://docs.payroc.com/knowledge/basic-concepts/hypermedia-as-the-engine-of-application-state-hateoas).
     */
    #[JsonProperty('link')]
    public ProcessingTerminalSummaryLink $link;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   link: ProcessingTerminalSummaryLink,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->link = $values['link'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
