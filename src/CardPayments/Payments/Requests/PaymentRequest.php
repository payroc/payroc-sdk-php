<?php

namespace Payroc\CardPayments\Payments\Requests;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\CardPayments\Payments\Types\PaymentRequestChannel;
use Payroc\Core\Json\JsonProperty;
use Payroc\Types\PaymentOrderRequest;
use Payroc\Types\Customer;
use Payroc\Types\IpAddress;
use Payroc\CardPayments\Payments\Types\PaymentRequestPaymentMethod;
use Payroc\CardPayments\Payments\Types\PaymentRequestThreeDSecure;
use Payroc\Types\SchemasCredentialOnFile;
use Payroc\Types\OfflineProcessing;
use Payroc\Types\CustomField;
use Payroc\Core\Types\ArrayType;

class PaymentRequest extends JsonSerializableType
{
    /**
     * @var string $idempotencyKey Unique identifier that you generate for each request. You must use the [UUID v4 format](https://www.rfc-editor.org/rfc/rfc4122) for the identifier. For more information about the idempotency key, go to [Idempotency](https://docs.payroc.com/api/idempotency).
     */
    public string $idempotencyKey;

    /**
     * @var value-of<PaymentRequestChannel> $channel Channel that the merchant used to receive the payment details.
     */
    #[JsonProperty('channel')]
    public string $channel;

    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var ?string $operator Operator who ran the transaction.
     */
    #[JsonProperty('operator')]
    public ?string $operator;

    /**
     * @var PaymentOrderRequest $order
     */
    #[JsonProperty('order')]
    public PaymentOrderRequest $order;

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
     * @var PaymentRequestPaymentMethod $paymentMethod Object that contains information about the customer's payment details.
     */
    #[JsonProperty('paymentMethod')]
    public PaymentRequestPaymentMethod $paymentMethod;

    /**
     * @var ?PaymentRequestThreeDSecure $threeDSecure Object that contains information for an authentication check on the customer's payment details using the 3-D Secure protocol.
     */
    #[JsonProperty('threeDSecure')]
    public ?PaymentRequestThreeDSecure $threeDSecure;

    /**
     * @var ?SchemasCredentialOnFile $credentialOnFile
     */
    #[JsonProperty('credentialOnFile')]
    public ?SchemasCredentialOnFile $credentialOnFile;

    /**
     * @var ?OfflineProcessing $offlineProcessing
     */
    #[JsonProperty('offlineProcessing')]
    public ?OfflineProcessing $offlineProcessing;

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
     * @var ?array<CustomField> $customFields Array of customField objects.
     */
    #[JsonProperty('customFields'), ArrayType([CustomField::class])]
    public ?array $customFields;

    /**
     * @param array{
     *   idempotencyKey: string,
     *   channel: value-of<PaymentRequestChannel>,
     *   processingTerminalId: string,
     *   order: PaymentOrderRequest,
     *   paymentMethod: PaymentRequestPaymentMethod,
     *   operator?: ?string,
     *   customer?: ?Customer,
     *   ipAddress?: ?IpAddress,
     *   threeDSecure?: ?PaymentRequestThreeDSecure,
     *   credentialOnFile?: ?SchemasCredentialOnFile,
     *   offlineProcessing?: ?OfflineProcessing,
     *   autoCapture?: ?bool,
     *   processAsSale?: ?bool,
     *   customFields?: ?array<CustomField>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->idempotencyKey = $values['idempotencyKey'];
        $this->channel = $values['channel'];
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->operator = $values['operator'] ?? null;
        $this->order = $values['order'];
        $this->customer = $values['customer'] ?? null;
        $this->ipAddress = $values['ipAddress'] ?? null;
        $this->paymentMethod = $values['paymentMethod'];
        $this->threeDSecure = $values['threeDSecure'] ?? null;
        $this->credentialOnFile = $values['credentialOnFile'] ?? null;
        $this->offlineProcessing = $values['offlineProcessing'] ?? null;
        $this->autoCapture = $values['autoCapture'] ?? null;
        $this->processAsSale = $values['processAsSale'] ?? null;
        $this->customFields = $values['customFields'] ?? null;
    }
}
