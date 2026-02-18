<?php

namespace Payroc\PaymentFeatures\Bank\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\PaymentFeatures\Bank\Types\BankAccountVerificationRequestBankAccount;

class BankAccountVerificationRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * Polymorphic object that contains bank account information.
     *
     * The value of the type field determines which variant you should use:
     * -	`ach` - Automated Clearing House (ACH) details
     * -	`pad` - Pre-authorized debit (PAD) details
     *
     * @var BankAccountVerificationRequestBankAccount $bankAccount
     */
    #[JsonProperty('bankAccount')]
    public BankAccountVerificationRequestBankAccount $bankAccount;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId: string,
     *   bankAccount: BankAccountVerificationRequestBankAccount,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->bankAccount = $values['bankAccount'];
    }
}
