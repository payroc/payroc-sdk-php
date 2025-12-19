<?php

namespace Payroc\Traits;

use DateTime;
use Payroc\Types\BaseIntentStatus;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\Date;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the base fees.
 *
 * @property ?string $id
 * @property ?DateTime $createdDate
 * @property ?DateTime $lastUpdatedDate
 * @property ?value-of<BaseIntentStatus> $status
 * @property string $key
 * @property ?array<string, string> $metadata
 */
trait BaseIntent
{
    /**
     * @var ?string $id Unique identifier of the pricing intent.
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?DateTime $createdDate Date and time that we received your request to create the pricing intent. We return this value in the [ISO-8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastUpdatedDate Date and time that the pricing intent was last modified. We return this value in the [ISO-8601](https://www.iso.org/iso-8601-date-and-time-format.html) format.
     */
    #[JsonProperty('lastUpdatedDate'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $lastUpdatedDate;

    /**
     * Status of the pricing intent. The value can be one of the following:
     * - `active` - We have approved the pricing intent.
     * - `pendingReview` - We have not yet reviewed the pricing intent.
     * - `rejected` - We have rejected the pricing intent.
     *
     * @var ?value-of<BaseIntentStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var string $key Unique identifier that you can assign to the pricing intent for your own records.
     */
    #[JsonProperty('key')]
    public string $key;

    /**
     * @var ?array<string, string> $metadata [Metadata](https://docs.payroc.com/api/metadata) object that contains your custom data.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;
}
