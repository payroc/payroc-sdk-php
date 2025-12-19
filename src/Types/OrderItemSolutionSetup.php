<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

/**
 * Object that contains the settings for the solution, including gateway settings, device settings, and application settings.
 */
class OrderItemSolutionSetup extends JsonSerializableType
{
    /**
     * @var ?value-of<SchemasTimezone> $timezone
     */
    #[JsonProperty('timezone')]
    public ?string $timezone;

    /**
     * Unique identifier of the industry template you want to apply to the solution. Send one of the following values:
     * - `Retail`
     * - `Restaurant`
     * - `Moto`
     * - `Ecommerce`
     *
     * @var ?string $industryTemplateId
     */
    #[JsonProperty('industryTemplateId')]
    public ?string $industryTemplateId;

    /**
     * @var ?OrderItemSolutionSetupGatewaySettings $gatewaySettings Object that contains the gateway settings for the solution.
     */
    #[JsonProperty('gatewaySettings')]
    public ?OrderItemSolutionSetupGatewaySettings $gatewaySettings;

    /**
     * @var ?OrderItemSolutionSetupApplicationSettings $applicationSettings Object that contains the application settings for the solution.
     */
    #[JsonProperty('applicationSettings')]
    public ?OrderItemSolutionSetupApplicationSettings $applicationSettings;

    /**
     * @var ?OrderItemSolutionSetupDeviceSettings $deviceSettings Object that contains the device settings if the solution includes a terminal or a peripheral device such as a printer.
     */
    #[JsonProperty('deviceSettings')]
    public ?OrderItemSolutionSetupDeviceSettings $deviceSettings;

    /**
     * @var ?OrderItemSolutionSetupBatchClosure $batchClosure Object that contains information about when and how the terminal closes the batch.
     */
    #[JsonProperty('batchClosure')]
    public ?OrderItemSolutionSetupBatchClosure $batchClosure;

    /**
     * @var ?OrderItemSolutionSetupReceiptNotifications $receiptNotifications Object that indicates if the terminal can send email receipts, text receipts, or both.
     */
    #[JsonProperty('receiptNotifications')]
    public ?OrderItemSolutionSetupReceiptNotifications $receiptNotifications;

    /**
     * @var ?array<OrderItemSolutionSetupTaxesItem> $taxes Array of tax objects that contains the taxes that apply to the merchant's transactions.
     */
    #[JsonProperty('taxes'), ArrayType([OrderItemSolutionSetupTaxesItem::class])]
    public ?array $taxes;

    /**
     * @var ?OrderItemSolutionSetupTips $tips Object that contains the tip options for transactions ran on the terminal.
     */
    #[JsonProperty('tips')]
    public ?OrderItemSolutionSetupTips $tips;

    /**
     * @var ?bool $tokenization Indicates if the terminal can tokenize customer's payment details. For more information about tokenization, go to [Tokenization.](https://docs.payroc.com/knowledge/basic-concepts/tokenization)
     */
    #[JsonProperty('tokenization')]
    public ?bool $tokenization;

    /**
     * @param array{
     *   timezone?: ?value-of<SchemasTimezone>,
     *   industryTemplateId?: ?string,
     *   gatewaySettings?: ?OrderItemSolutionSetupGatewaySettings,
     *   applicationSettings?: ?OrderItemSolutionSetupApplicationSettings,
     *   deviceSettings?: ?OrderItemSolutionSetupDeviceSettings,
     *   batchClosure?: ?OrderItemSolutionSetupBatchClosure,
     *   receiptNotifications?: ?OrderItemSolutionSetupReceiptNotifications,
     *   taxes?: ?array<OrderItemSolutionSetupTaxesItem>,
     *   tips?: ?OrderItemSolutionSetupTips,
     *   tokenization?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->timezone = $values['timezone'] ?? null;
        $this->industryTemplateId = $values['industryTemplateId'] ?? null;
        $this->gatewaySettings = $values['gatewaySettings'] ?? null;
        $this->applicationSettings = $values['applicationSettings'] ?? null;
        $this->deviceSettings = $values['deviceSettings'] ?? null;
        $this->batchClosure = $values['batchClosure'] ?? null;
        $this->receiptNotifications = $values['receiptNotifications'] ?? null;
        $this->taxes = $values['taxes'] ?? null;
        $this->tips = $values['tips'] ?? null;
        $this->tokenization = $values['tokenization'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
