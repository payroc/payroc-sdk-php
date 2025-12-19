<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about a multi-use payment link.
 */
class MultiUsePaymentLink extends JsonSerializableType
{
    /**
     * @var ?string $paymentLinkId Unique identifier that we assigned to the payment link.
     */
    #[JsonProperty('paymentLinkId')]
    public ?string $paymentLinkId;

    /**
     * @var string $merchantReference Unique identifier that the merchant assigned to the payment.
     */
    #[JsonProperty('merchantReference')]
    public string $merchantReference;

    /**
     * @var MultiUsePaymentLinkOrder $order
     */
    #[JsonProperty('order')]
    public MultiUsePaymentLinkOrder $order;

    /**
     * @var value-of<MultiUsePaymentLinkAuthType> $authType Type of transaction.
     */
    #[JsonProperty('authType')]
    public string $authType;

    /**
     * Payment methods that the merchant accepts.
     * **Note:** If a payment is a pre-authorization, the customer must pay by card.
     *
     * @var array<value-of<MultiUsePaymentLinkPaymentMethodsItem>> $paymentMethods
     */
    #[JsonProperty('paymentMethods'), ArrayType(['string'])]
    public array $paymentMethods;

    /**
     * Array of customLabel objects.
     * **Note:** You can change the label of the payment button only.
     *
     * @var ?array<CustomLabel> $customLabels
     */
    #[JsonProperty('customLabels'), ArrayType([CustomLabel::class])]
    public ?array $customLabels;

    /**
     * @var ?PaymentLinkAssets $assets
     */
    #[JsonProperty('assets')]
    public ?PaymentLinkAssets $assets;

    /**
     * Status of the payment link. The value is one of the following:
     * - `active` - Payment link is active.
     * - `completed` - Customer has paid.
     * - `deactivated` - Merchant has deactivated the link.
     * - `expired` - Payment link has expired.
     *
     * @var ?value-of<MultiUsePaymentLinkStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?DateTime $createdOn Date that the merchant created the link. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdOn'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdOn;

    /**
     * @var ?DateTime $expiresOn Last date that the customer can use the payment link. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('expiresOn'), Date(Date::TYPE_DATE)]
    public ?DateTime $expiresOn;

    /**
     * @var ?CredentialOnFile $credentialOnFile
     */
    #[JsonProperty('credentialOnFile')]
    public ?CredentialOnFile $credentialOnFile;

    /**
     * @param array{
     *   merchantReference: string,
     *   order: MultiUsePaymentLinkOrder,
     *   authType: value-of<MultiUsePaymentLinkAuthType>,
     *   paymentMethods: array<value-of<MultiUsePaymentLinkPaymentMethodsItem>>,
     *   paymentLinkId?: ?string,
     *   customLabels?: ?array<CustomLabel>,
     *   assets?: ?PaymentLinkAssets,
     *   status?: ?value-of<MultiUsePaymentLinkStatus>,
     *   createdOn?: ?DateTime,
     *   expiresOn?: ?DateTime,
     *   credentialOnFile?: ?CredentialOnFile,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->paymentLinkId = $values['paymentLinkId'] ?? null;
        $this->merchantReference = $values['merchantReference'];
        $this->order = $values['order'];
        $this->authType = $values['authType'];
        $this->paymentMethods = $values['paymentMethods'];
        $this->customLabels = $values['customLabels'] ?? null;
        $this->assets = $values['assets'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->createdOn = $values['createdOn'] ?? null;
        $this->expiresOn = $values['expiresOn'] ?? null;
        $this->credentialOnFile = $values['credentialOnFile'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
