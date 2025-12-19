<?php

namespace Payroc\PayrocCloud\PaymentInstructions\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\PaymentInstructionOrder;
use Payroc\Types\Customer;
use Payroc\Types\IpAddress;
use Payroc\Types\SchemasCredentialOnFile;
use Payroc\Types\CustomizationOptions;

class PaymentInstructionRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var ?string $operator Operator who initiated the request.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var PaymentInstructionOrder $order
     */
    #[JsonProperty('order')]
    public PaymentInstructionOrder $order;

    /**
     * @var ?Customer $customer
     */
    #[JsonProperty('customer')]
    public ?Customer $customer;

    /**
     * @var ?IpAddress $ipAddress
     */
    #[JsonProperty('ipAddress')]
    public ?IpAddress $ipAddress;

    /**
     * @var ?SchemasCredentialOnFile $credentialOnFile
     */
    #[JsonProperty('credentialOnFile')]
    public ?SchemasCredentialOnFile $credentialOnFile;

    /**
     * @var ?CustomizationOptions $customizationOptions
     */
    #[JsonProperty('customizationOptions')]
    public ?CustomizationOptions $customizationOptions;

    /**
     * Indicates if we should automatically capture the payment amount.
     *
     * - `true` - Run a sale and automatically capture the transaction.
     * - `false`- Run a pre-authorization and capture the transaction later.
     *
     * **Note:** If you send `false` and the terminal doesn't support pre-authorization, we set the transaction's status to pending. The merchant must capture the transaction to take payment from the customer.
     *
     * @var ?bool $autoCapture
     */
    #[JsonProperty('autoCapture')]
    public ?bool $autoCapture;

    /**
     * Indicates if we should immediately settle the sale transaction. The merchant cannot adjust the transaction if we immediately settle it.
     * **Note:** If the value for **processAsSale** is `true`, the gateway ignores the value in **autoCapture**.
     *
     * @var ?bool $processAsSale
     */
    #[JsonProperty('processAsSale')]
    public ?bool $processAsSale;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   processingTerminalId: string,
     *   order: PaymentInstructionOrder,
     *   operator?: ?string,
     *   customer?: ?Customer,
     *   ipAddress?: ?IpAddress,
     *   credentialOnFile?: ?SchemasCredentialOnFile,
     *   customizationOptions?: ?CustomizationOptions,
     *   autoCapture?: ?bool,
     *   processAsSale?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->operator = $values['operator'] ?? null;
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->ipAddress = $values['ipAddress'] ?? null;
        $this->credentialOnFile = $values['credentialOnFile'] ?? null;
        $this->customizationOptions = $values['customizationOptions'] ?? null;
        $this->autoCapture = $values['autoCapture'] ?? null;
        $this->processAsSale = $values['processAsSale'] ?? null;
    }
}
