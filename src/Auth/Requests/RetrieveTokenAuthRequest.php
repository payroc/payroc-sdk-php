<?php

namespace Payroc\Auth\Requests;

use Payroc\Core\Json\JsonSerializableType;

class RetrieveTokenAuthRequest extends JsonSerializableType
{
    /**
     * @var string $apiKey The API key of the application
     */
    public string $apiKey;

    /**
     * @param array{
     *   apiKey: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->apiKey = $values['apiKey'];
    }
}
