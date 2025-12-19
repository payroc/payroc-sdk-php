<?php

namespace Payroc\Boarding\PricingIntents\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\PricingIntent50;

class UpdatePricingIntentsRequest extends JsonSerializableType
{
    /**
     * @var PricingIntent50 $body
     */
    public PricingIntent50 $body;

    /**
     * @param array{
     *   body: PricingIntent50,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
