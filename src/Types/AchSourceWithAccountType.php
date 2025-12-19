<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Traits\AchSource;
use Payroc\Core\Json\JsonProperty;

class AchSourceWithAccountType extends JsonSerializableType
{
    use AchSource;

    /**
     * @var ?value-of<AchSourceWithAccountTypeAccountType> $accountType Indicates the customer's account type.
     */
    #[JsonProperty('accountType')]
    public ?string $accountType;

    /**
     * @param array{
     *   nameOnAccount: string,
     *   accountNumber: string,
     *   routingNumber: string,
     *   accountType?: ?value-of<AchSourceWithAccountTypeAccountType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->nameOnAccount = $values['nameOnAccount'];
        $this->accountNumber = $values['accountNumber'];
        $this->routingNumber = $values['routingNumber'];
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
