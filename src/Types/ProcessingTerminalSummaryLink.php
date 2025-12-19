<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Array of links related to your request. For more information about HATEOAS, go to [Hypermedia as the engine of application state](https://docs.payroc.com/knowledge/basic-concepts/hypermedia-as-the-engine-of-application-state-hateoas).
 */
class ProcessingTerminalSummaryLink extends JsonSerializableType
{
    /**
     * @var string $href URL of the target resource.
     */
    #[JsonProperty('href')]
    public string $href;

    /**
     * @var string $rel Indicates the relationship between the current resource and the target resource.
     */
    #[JsonProperty('rel')]
    public string $rel;

    /**
     * @var string $method HTTP method that you need to use with the target resource.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @param array{
     *   href: string,
     *   rel: string,
     *   method: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->href = $values['href'];
        $this->rel = $values['rel'];
        $this->method = $values['method'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
