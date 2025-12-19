<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains the details of the payment card.
 */
class RetrievedCard extends JsonSerializableType
{
    /**
     * @var string $type Card brand that the card is linked to. For example, Visa.
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var ?value-of<RetrievedCardEntryMethod> $entryMethod Method that the device used to capture the card details.
     */
    #[JsonProperty('entryMethod')]
    public ?string $entryMethod;

    /**
     * @var ?string $cardholderName Cardholder’s name.
     */
    #[JsonProperty('cardholderName')]
    public ?string $cardholderName;

    /**
     * @var ?string $cardholderSignature Cardholder’s signature.
     */
    #[JsonProperty('cardholderSignature')]
    public ?string $cardholderSignature;

    /**
     * @var string $cardNumber Masked card number. Our gateway shows only the first six digits and the last four digits of the card number, for example, 500165******0000.
     */
    #[JsonProperty('cardNumber')]
    public string $cardNumber;

    /**
     * @var string $expiryDate Expiry date of the customer's card. The format is in **MMYY**.
     */
    #[JsonProperty('expiryDate')]
    public string $expiryDate;

    /**
     * @var ?SecureTokenSummary $secureToken
     */
    #[JsonProperty('secureToken')]
    public ?SecureTokenSummary $secureToken;

    /**
     * @var ?SecurityCheck $securityChecks
     */
    #[JsonProperty('securityChecks')]
    public ?SecurityCheck $securityChecks;

    /**
     * @var ?array<EmvTag> $emvTags Array of emvTag objects.
     */
    #[JsonProperty('emvTags'), ArrayType([EmvTag::class])]
    public ?array $emvTags;

    /**
     * @var ?array<CardBalance> $balances Array of cardBalance objects. Our gateway returns this array only when the customer uses an Electronic Benefit Transfer (EBT) card.
     */
    #[JsonProperty('balances'), ArrayType([CardBalance::class])]
    public ?array $balances;

    /**
     * @param array{
     *   type: string,
     *   cardNumber: string,
     *   expiryDate: string,
     *   entryMethod?: ?value-of<RetrievedCardEntryMethod>,
     *   cardholderName?: ?string,
     *   cardholderSignature?: ?string,
     *   secureToken?: ?SecureTokenSummary,
     *   securityChecks?: ?SecurityCheck,
     *   emvTags?: ?array<EmvTag>,
     *   balances?: ?array<CardBalance>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->entryMethod = $values['entryMethod'] ?? null;
        $this->cardholderName = $values['cardholderName'] ?? null;
        $this->cardholderSignature = $values['cardholderSignature'] ?? null;
        $this->cardNumber = $values['cardNumber'];
        $this->expiryDate = $values['expiryDate'];
        $this->secureToken = $values['secureToken'] ?? null;
        $this->securityChecks = $values['securityChecks'] ?? null;
        $this->emvTags = $values['emvTags'] ?? null;
        $this->balances = $values['balances'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
