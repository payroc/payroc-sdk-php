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
     * @var BankAccountVerificationRequestBankAccount $bankAccount Object that contains information about the bank account.
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
