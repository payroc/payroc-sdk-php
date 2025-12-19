<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;
use DateTime;
use Payroc\Core\Types\Date;

/**
 * Object that contains information about a single-use payment link.
 */
class SingleUsePaymentLink extends JsonSerializableType
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
     * @var SingleUsePaymentLinkOrder $order
     */
    #[JsonProperty('order')]
    public SingleUsePaymentLinkOrder $order;

    /**
     * @var value-of<SingleUsePaymentLinkAuthType> $authType Type of transaction.
     */
    #[JsonProperty('authType')]
    public string $authType;

    /**
     * Payment methods that the merchant accepts.
     * **Note:** If the payment is a pre-authorization, the customer must pay by card.
     *
     * @var array<value-of<SingleUsePaymentLinkPaymentMethodsItem>> $paymentMethods
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
     * @var ?value-of<SingleUsePaymentLinkStatus> $status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?DateTime $createdOn Date that the merchant created the link. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('createdOn'), Date(Date::TYPE_DATE)]
    public ?DateTime $createdOn;

    /**
     * @var DateTime $expiresOn Last date that the customer can use the payment link. The format of this value is **YYYY-MM-DD**.
     */
    #[JsonProperty('expiresOn'), Date(Date::TYPE_DATE)]
    public DateTime $expiresOn;

    /**
     * @var ?CredentialOnFile $credentialOnFile
     */
    #[JsonProperty('credentialOnFile')]
    public ?CredentialOnFile $credentialOnFile;

    /**
     * @param array{
     *   merchantReference: string,
     *   order: SingleUsePaymentLinkOrder,
     *   authType: value-of<SingleUsePaymentLinkAuthType>,
     *   paymentMethods: array<value-of<SingleUsePaymentLinkPaymentMethodsItem>>,
     *   expiresOn: DateTime,
     *   paymentLinkId?: ?string,
     *   customLabels?: ?array<CustomLabel>,
     *   assets?: ?PaymentLinkAssets,
     *   status?: ?value-of<SingleUsePaymentLinkStatus>,
     *   createdOn?: ?DateTime,
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
        $this->expiresOn = $values['expiresOn'];
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
