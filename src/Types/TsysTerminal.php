<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;

/**
 * Object that contains the configuration settings for the terminal.
 */
class TsysTerminal extends JsonSerializableType
{
    /**
     * @var string $terminalId Unique identifier that the host processor assigned to the terminal.
     */
    #[JsonProperty('terminalId')]
    public string $terminalId;

    /**
     * @var string $terminalNumber Unique identifier of the terminal at the merchant's site.
     */
    #[JsonProperty('terminalNumber')]
    public string $terminalNumber;

    /**
     * @var ?string $authenticationCode Authenticates the terminal's identity with the host processor.
     */
    #[JsonProperty('authenticationCode')]
    public ?string $authenticationCode;

    /**
     * @var ?string $sharingGroups Indicates the direct debit networks and EBT networks that the terminal can use.
     */
    #[JsonProperty('sharingGroups')]
    public ?string $sharingGroups;

    /**
     * @var ?bool $motoAllowed Indicates if the terminal can run Mail Order/Telephone Order (MOTO) transactions.
     */
    #[JsonProperty('motoAllowed')]
    public ?bool $motoAllowed;

    /**
     * @var ?bool $internetAllowed Indicates if the terminal can run e-Commerce transactions.
     */
    #[JsonProperty('internetAllowed')]
    public ?bool $internetAllowed;

    /**
     * @var ?bool $cardPresentAllowed Indicates if the terminal can run card present transactions.
     */
    #[JsonProperty('cardPresentAllowed')]
    public ?bool $cardPresentAllowed;

    /**
     * @param array{
     *   terminalId: string,
     *   terminalNumber: string,
     *   authenticationCode?: ?string,
     *   sharingGroups?: ?string,
     *   motoAllowed?: ?bool,
     *   internetAllowed?: ?bool,
     *   cardPresentAllowed?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->terminalId = $values['terminalId'];
        $this->terminalNumber = $values['terminalNumber'];
        $this->authenticationCode = $values['authenticationCode'] ?? null;
        $this->sharingGroups = $values['sharingGroups'] ?? null;
        $this->motoAllowed = $values['motoAllowed'] ?? null;
        $this->internetAllowed = $values['internetAllowed'] ?? null;
        $this->cardPresentAllowed = $values['cardPresentAllowed'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
