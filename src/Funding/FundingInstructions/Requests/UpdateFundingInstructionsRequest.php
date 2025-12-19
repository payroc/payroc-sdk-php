<?php

namespace Payroc\Funding\FundingInstructions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Types\Instruction;

class UpdateFundingInstructionsRequest extends JsonSerializableType
{
    /**
     * @var Instruction $body
     */
    public Instruction $body;

    /**
     * @param array{
     *   body: Instruction,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->body = $values['body'];
    }
}
