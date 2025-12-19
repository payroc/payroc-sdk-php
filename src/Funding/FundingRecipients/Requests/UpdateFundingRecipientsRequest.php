<?php

namespace Payroc\Funding\FundingRecipients\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\FundingRecipient;

class UpdateFundingRecipientsRequest extends JsonSerializableType
{
    /**
     * @var FundingRecipient $body
     */
    public FundingRecipient $body;

    /**
     * @param array{
     *   body: FundingRecipient,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
