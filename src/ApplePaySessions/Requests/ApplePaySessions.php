<?php

namespace Payroc\ApplePaySessions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

class ApplePaySessions extends JsonSerializableType
{
    /**
     * @var string $appleDomainId Unique appleDomainId of the merchant's domain that we assigned when you added their domain to our Self-Care Portal.
     */
    #[JsonProperty('appleDomainId')]
    public string $appleDomainId;

    /**
     * @var string $appleValidationUrl Validation URL from the Apple Pay JS API.
     */
    #[JsonProperty('appleValidationUrl')]
    public string $appleValidationUrl;

    /**
     * @param array{
     *   appleDomainId: string,
     *   appleValidationUrl: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->appleDomainId = $values['appleDomainId'];
        $this->appleValidationUrl = $values['appleValidationUrl'];
    }
}
