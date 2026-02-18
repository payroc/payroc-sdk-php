<?php

namespace Payroc\PaymentFeatures\Cards\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\Currency;
use Payroc\Types\Customer;
use Payroc\PaymentFeatures\Cards\Types\BalanceInquiryCard;

class BalanceInquiry extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who requested the balance inquiry.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var value-of<Currency> $currency
     */
    #[JsonProperty('currency')]
    public string $currency;

    /**
     * @var ?Customer $customer
     */
    #[JsonProperty('customer')]
    public ?Customer $customer;

    /**
     * Polymorphic object that contains payment details.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`card` - Payment card details
     * -	`singleUseToken` - Single-use token details
     *
     * @var BalanceInquiryCard $card
     */
    #[JsonProperty('card')]
    public BalanceInquiryCard $card;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   currency: value-of<Currency>,
     *   card: BalanceInquiryCard,
     *   operator?: ?string,
     *   customer?: ?Customer,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->currency = $values['currency'];
        $this->customer = $values['customer'] ?? null;
        $this->card = $values['card'];
    }
}
