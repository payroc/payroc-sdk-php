<?php

namespace Payroc\BankTransferPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\BankTransferPaymentRequestOrder;
use Payroc\Types\BankTransferCustomer;
use Payroc\Types\SchemasCredentialOnFile;
use Payroc\BankTransferPayments\Payments\Types\BankTransferPaymentRequestPaymentMethod;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class BankTransferPaymentRequest extends JsonSerializableType
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
     * @var BankTransferPaymentRequestOrder $order
     */
    #[JsonProperty('order')]
    public BankTransferPaymentRequestOrder $order;

    /**
     * @var ?BankTransferCustomer $customer
     */
    #[JsonProperty('customer')]
    public ?BankTransferCustomer $customer;

    /**
     * @var ?SchemasCredentialOnFile $credentialOnFile
     */
    #[JsonProperty('credentialOnFile')]
    public ?SchemasCredentialOnFile $credentialOnFile;

    /**
     * Polymorphic object that contains payment detail information.
     *
     * The value of the type parameter determines which variant you should use:
     * -	`ach` - Automated Clearing House (ACH) details
     * -	`pad` - Pre-authorized debit (PAD) details
     * -	`secureToken` - Secure token details
     * -	`singleUseToken` - Single-use token details
     *
     * @var BankTransferPaymentRequestPaymentMethod $paymentMethod
     */
    #[JsonProperty('paymentMethod')]
    public BankTransferPaymentRequestPaymentMethod $paymentMethod;

    /**
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId: string,
     *   order: BankTransferPaymentRequestOrder,
     *   paymentMethod: BankTransferPaymentRequestPaymentMethod,
     *   customer?: ?BankTransferCustomer,
     *   credentialOnFile?: ?SchemasCredentialOnFile,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->credentialOnFile = $values['credentialOnFile'] ?? null;
        $this->paymentMethod = $values['paymentMethod'];
        $this->customFields = $values['customFields'] ?? null;
    }
}
