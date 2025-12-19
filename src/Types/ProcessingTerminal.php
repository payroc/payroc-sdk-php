<?php

namespace Payroc\Types;

use Payroc\Core\Json\JsonSerializableType;
use Payroc\Core\Json\JsonProperty;
use Payroc\Core\Types\ArrayType;

class ProcessingTerminal extends JsonSerializableType
{
    /**
     * @var string $processingTerminalId Unique identifier that we assigned to the processing terminal.
     */
    #[JsonProperty('processingTerminalId')]
    public string $processingTerminalId;

    /**
     * @var value-of<ProcessingTerminalStatus> $status Indicates if the processing terminal is active.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var value-of<ProcessingTerminalTimezone> $timezone Time zone of the processing terminal.
     */
    #[JsonProperty('timezone')]
    public string $timezone;

    /**
     * @var ?string $program Name of the product and its setup.
     */
    #[JsonProperty('program')]
    public ?string $program;

    /**
     * @var ?PayrocGateway $gateway Object that contains the gateway settings for the solution.
     */
    #[JsonProperty('gateway')]
    public ?PayrocGateway $gateway;

    /**
     * @var ProcessingTerminalBatchClosure $batchClosure Object that contains information about when and how the terminal closes the batch.
     */
    #[JsonProperty('batchClosure')]
    public ProcessingTerminalBatchClosure $batchClosure;

    /**
     * @var ProcessingTerminalApplicationSettings $applicationSettings Object that contains the application settings for the solution.
     */
    #[JsonProperty('applicationSettings')]
    public ProcessingTerminalApplicationSettings $applicationSettings;

    /**
     * @var ProcessingTerminalFeatures $features Object that contains the feature settings for the terminal.
     */
    #[JsonProperty('features')]
    public ProcessingTerminalFeatures $features;

    /**
     * @var ?array<ProcessingTerminalTaxesItem> $taxes Array of tax objects that contains the taxes that apply to the merchant's transactions.
     */
    #[JsonProperty('taxes'), ArrayType([ProcessingTerminalTaxesItem::class])]
    public ?array $taxes;

    /**
     * @var ?ProcessingTerminalSecurity $security Object that contains the tokenization settings and AVS settings for the terminal.
     */
    #[JsonProperty('security')]
    public ?ProcessingTerminalSecurity $security;

    /**
     * @var ?ProcessingTerminalReceiptNotifications $receiptNotifications Object that indicates if the terminal can send email receipts or text receipts.
     */
    #[JsonProperty('receiptNotifications')]
    public ?ProcessingTerminalReceiptNotifications $receiptNotifications;

    /**
     * @var ?array<ProcessingTerminalDevicesItem> $devices Array of device objects. Each object contains information about a device using the processing terminal's configuration.
     */
    #[JsonProperty('devices'), ArrayType([ProcessingTerminalDevicesItem::class])]
    public ?array $devices;

    /**
     * @param array{
     *   processingTerminalId: string,
     *   status: value-of<ProcessingTerminalStatus>,
     *   timezone: value-of<ProcessingTerminalTimezone>,
     *   batchClosure: ProcessingTerminalBatchClosure,
     *   applicationSettings: ProcessingTerminalApplicationSettings,
     *   features: ProcessingTerminalFeatures,
     *   program?: ?string,
     *   gateway?: ?PayrocGateway,
     *   taxes?: ?array<ProcessingTerminalTaxesItem>,
     *   security?: ?ProcessingTerminalSecurity,
     *   receiptNotifications?: ?ProcessingTerminalReceiptNotifications,
     *   devices?: ?array<ProcessingTerminalDevicesItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->processingTerminalId = $values['processingTerminalId'];
        $this->status = $values['status'];
        $this->timezone = $values['timezone'];
        $this->program = $values['program'] ?? null;
        $this->gateway = $values['gateway'] ?? null;
        $this->batchClosure = $values['batchClosure'];
        $this->applicationSettings = $values['applicationSettings'];
        $this->features = $values['features'];
        $this->taxes = $values['taxes'] ?? null;
        $this->security = $values['security'] ?? null;
        $this->receiptNotifications = $values['receiptNotifications'] ?? null;
        $this->devices = $values['devices'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
