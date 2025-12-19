<?php

namespace Payroc\Funding\FundingAccounts\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\FundingAccount;

class UpdateFundingAccountsRequest extends JsonSerializableType
{
    /**
     * @var FundingAccount $body
     */
    public FundingAccount $body;

    /**
     * @param array{
     *   body: FundingAccount,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
