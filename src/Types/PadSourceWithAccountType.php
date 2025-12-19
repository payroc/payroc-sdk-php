<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\PadSource;
use Payroc\Core\Json\JsonProperty;

class PadSourceWithAccountType extends JsonSerializableType
{
    use PadSource;

    /**
     * @var ?value-of<PadSourceWithAccountTypeAccountType> $accountType Indicates the customer's account type.
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   transitNumber: string,
     *   institutionNumber: string,
     *   accountType?: ?value-of<PadSourceWithAccountTypeAccountType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->accountNumber = $values['accountNumber'];
        $this->transitNumber = $values['transitNumber'];
        $this->institutionNumber = $values['institutionNumber'];
        $this->accountType = $values['accountType'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
