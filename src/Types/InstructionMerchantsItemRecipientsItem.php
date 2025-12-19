<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains information about the target funding account.
 */
class InstructionMerchantsItemRecipientsItem extends JsonSerializableType
{
    /**
     * @var int $fundingAccountId Unique identifier that we assigned to the funding account.
     */
    #[JsonProperty('fundingAccountId')]
    public int $fundingAccountId;

    /**
     * @var value-of<InstructionMerchantsItemRecipientsItemPaymentMethod> $paymentMethod Payment method that we use to send funds to the funding account.
     */
    #[JsonProperty('paymentMethod')]
    public string $paymentMethod;

    /**
     * @var InstructionMerchantsItemRecipientsItemAmount $amount Object that contains information about the funds that we send to the funding account.
     */
    #[JsonProperty('amount')]
    public InstructionMerchantsItemRecipientsItemAmount $amount;

    /**
     * Status of the individual payment instruction. Our gateway returns one of the following values:
     * -	`accepted` - We received the payment instruction, but we haven't reviewed it.
     * -	`pending` - We are reviewing the payment instruction.
     * -	`released` - We approved the payment instruction.
     * -	`funded` - We sent the funds to the funding account by ACH.
     * -	`failed` - The ACH payment to the funding account failed.
     * -	`rejected` - We reviewed the payment instruction and rejected it.
     * - `onHold` - We have placed the payment instruction on hold.
     *
     * @var ?value-of<InstructionMerchantsItemRecipientsItemStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?array<string, string> $metadata [Metadata](https://docs.payroc.com/api/metadata) object you can use to include custom data with your request.
     */
    #[JsonProperty('metadata'), ArrayType(['string' => 'string'])]
    public ?array $metadata;

    /**
     * @var ?InstructionMerchantsItemRecipientsItemLink $link Object that contains HATEOAS links for the resource.
     */
    #[JsonProperty('link')]
    public ?InstructionMerchantsItemRecipientsItemLink $link;

    /**
     * @param array{
     *   fundingAccountId: int,
     *   paymentMethod: value-of<InstructionMerchantsItemRecipientsItemPaymentMethod>,
     *   amount: InstructionMerchantsItemRecipientsItemAmount,
     *   status?: ?value-of<InstructionMerchantsItemRecipientsItemStatus>,
     *   metadata?: ?array<string, string>,
     *   link?: ?InstructionMerchantsItemRecipientsItemLink,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fundingAccountId = $values['fundingAccountId'];
        $this->paymentMethod = $values['paymentMethod'];
        $this->amount = $values['amount'];
        $this->status = $values['status'] ?? null;
        $this->metadata = $values['metadata'] ?? null;
        $this->link = $values['link'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
