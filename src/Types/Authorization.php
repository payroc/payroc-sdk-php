<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about the authorization.
 */
class Authorization extends JsonSerializableType
{
    /**
     * @var ?int $authorizationId Unique identifier that we assigned to the authorization.
     */
    #[JsonProperty('authorizationId')]
    public ?int $authorizationId;

    /**
     * @var ?DateTime $createdDate Date that we received the authorization. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdDate;

    /**
     * @var ?DateTime $lastModifiedDate Date that the authorization was last changed. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('lastModifiedDate'), Date(Date::TYPE_DATE)]
    public ?DateTime $lastModifiedDate;

    /**
     * @var ?value-of<AuthorizationAuthorizationResponse> $authorizationResponse Response from the issuing bank for the authorization.
     */
    #[JsonProperty('authorizationResponse')]
    public ?string $authorizationResponse;

    /**
     * @var ?int $preauthorizationRequestAmount Amount that the merchant requested for the authorization. We return the value in the currency's lowest denomination, for example, cents.
     */
    #[JsonProperty('preauthorizationRequestAmount')]
    public ?int $preauthorizationRequestAmount;

    /**
     * @var ?string $currency Currency of the authorization. The value for the currency follows the [ISO 4217](https://www.iso.org/iso-4217-currency-codes.html) standard.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?BatchSummary $batch
     */
    #[JsonProperty('batch')]
    public ?BatchSummary $batch;

    /**
     * @var ?CardSummary $card
     */
    #[JsonProperty('card')]
    public ?CardSummary $card;

    /**
     * @var ?MerchantSummary $merchant
     */
    #[JsonProperty('merchant')]
    public ?MerchantSummary $merchant;

    /**
     * @var ?TransactionSummary $transaction
     */
    #[JsonProperty('transaction')]
    public ?TransactionSummary $transaction;

    /**
     * @param array{
     *   authorizationId?: ?int,
     *   createdDate?: ?DateTime,
     *   lastModifiedDate?: ?DateTime,
     *   authorizationResponse?: ?value-of<AuthorizationAuthorizationResponse>,
     *   preauthorizationRequestAmount?: ?int,
     *   currency?: ?string,
     *   batch?: ?BatchSummary,
     *   card?: ?CardSummary,
     *   merchant?: ?MerchantSummary,
     *   transaction?: ?TransactionSummary,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->authorizationId = $values['authorizationId'] ?? null;
        $this->createdDate = $values['createdDate'] ?? null;
        $this->lastModifiedDate = $values['lastModifiedDate'] ?? null;
        $this->authorizationResponse = $values['authorizationResponse'] ?? null;
        $this->preauthorizationRequestAmount = $values['preauthorizationRequestAmount'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->batch = $values['batch'] ?? null;
        $this->card = $values['card'] ?? null;
        $this->merchant = $values['merchant'] ?? null;
        $this->transaction = $values['transaction'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
