<?php

namespace Payroc\Boarding\PricingIntents\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\PricingIntent52;

class UpdatePricingIntentsRequest extends JsonSerializableType
{
    /**
     * @var PricingIntent52 $body
     */
    public PricingIntent52 $body;

    /**
     * @param array{
     *   body: PricingIntent52,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
