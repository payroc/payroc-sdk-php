<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Boarding\ProcessingAccounts\Requests\ListContactsProcessingAccountsRequest;
use Payroc\Boarding\ProcessingAccounts\Requests\ListProcessingAccountOwnersRequest;
use Payroc\Boarding\ProcessingAccounts\Requests\CreateReminderProcessingAccountsRequest;
use Payroc\Boarding\ProcessingAccounts\Types\CreateReminderProcessingAccountsRequestBody;
use Payroc\Types\PricingAgreementReminder;
use Payroc\Boarding\ProcessingAccounts\Requests\ListTerminalOrdersProcessingAccountsRequest;
use Payroc\Boarding\ProcessingAccounts\Types\ListTerminalOrdersProcessingAccountsRequestStatus;
use DateTime;
use Payroc\Boarding\ProcessingAccounts\Requests\CreateTerminalOrder;
use Payroc\Types\TrainingProvider;
use Payroc\Boarding\ProcessingAccounts\Types\CreateTerminalOrderShipping;
use Payroc\Boarding\ProcessingAccounts\Types\CreateTerminalOrderShippingPreferences;
use Payroc\Boarding\ProcessingAccounts\Types\CreateTerminalOrderShippingPreferencesMethod;
use Payroc\Boarding\ProcessingAccounts\Types\CreateTerminalOrderShippingAddress;
use Payroc\Types\OrderItem;
use Payroc\Types\OrderItemType;
use Payroc\Types\OrderItemDeviceCondition;
use Payroc\Types\OrderItemSolutionSetup;
use Payroc\Types\SchemasTimezone;
use Payroc\Types\OrderItemSolutionSetupGatewaySettings;
use Payroc\Types\OrderItemSolutionSetupApplicationSettings;
use Payroc\Types\OrderItemSolutionSetupApplicationSettingsSecurity;
use Payroc\Types\OrderItemSolutionSetupDeviceSettings;
use Payroc\Types\OrderItemSolutionSetupDeviceSettingsCommunicationType;
use Payroc\Types\OrderItemSolutionSetupBatchClosure;
use Payroc\Types\AutomaticBatchClose;
use Payroc\Types\OrderItemSolutionSetupReceiptNotifications;
use Payroc\Types\OrderItemSolutionSetupTaxesItem;
use Payroc\Types\OrderItemSolutionSetupTips;
use Payroc\Boarding\ProcessingAccounts\Requests\ListProcessingTerminalsProcessingAccountsRequest;
use Payroc\Environments;

class BoardingProcessingAccountsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testRetrieve(): void {
        $testId = 'boarding.processing_accounts.retrieve.0';
        $this->client->boarding->processingAccounts->retrieve(
            '38765',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765",
            null,
            1
        );
    }

    /**
     */
    public function testListProcessingAccountFundingAccounts(): void {
        $testId = 'boarding.processing_accounts.list_processing_account_funding_accounts.0';
        $this->client->boarding->processingAccounts->listProcessingAccountFundingAccounts(
            '38765',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.list_processing_account_funding_accounts.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765/funding-accounts",
            null,
            1
        );
    }

    /**
     */
    public function testListContacts(): void {
        $testId = 'boarding.processing_accounts.list_contacts.0';
        $this->client->boarding->processingAccounts->listContacts(
            '38765',
            new ListContactsProcessingAccountsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.list_contacts.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765/contacts",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testGetProcessingAccountPricingAgreement(): void {
        $testId = 'boarding.processing_accounts.get_processing_account_pricing_agreement.0';
        $this->client->boarding->processingAccounts->getProcessingAccountPricingAgreement(
            '38765',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.get_processing_account_pricing_agreement.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765/pricing",
            null,
            1
        );
    }

    /**
     */
    public function testListOwners(): void {
        $testId = 'boarding.processing_accounts.list_owners.0';
        $this->client->boarding->processingAccounts->listOwners(
            '38765',
            new ListProcessingAccountOwnersRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.list_owners.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765/owners",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreateReminder(): void {
        $testId = 'boarding.processing_accounts.create_reminder.0';
        $this->client->boarding->processingAccounts->createReminder(
            '38765',
            new CreateReminderProcessingAccountsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => CreateReminderProcessingAccountsRequestBody::pricingAgreement(new PricingAgreementReminder([])),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.create_reminder.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-accounts/38765/reminders",
            null,
            1
        );
    }

    /**
     */
    public function testListTerminalOrders(): void {
        $testId = 'boarding.processing_accounts.list_terminal_orders.0';
        $this->client->boarding->processingAccounts->listTerminalOrders(
            '38765',
            new ListTerminalOrdersProcessingAccountsRequest([
                'status' => ListTerminalOrdersProcessingAccountsRequestStatus::Open->value,
                'fromDateTime' => new DateTime('2024-09-08T12:00:00Z'),
                'toDateTime' => new DateTime('2024-12-08T11:00:00Z'),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.list_terminal_orders.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765/terminal-orders",
            ['status' => 'open', 'fromDateTime' => '2024-09-08T12:00:00Z', 'toDateTime' => '2024-12-08T11:00:00Z'],
            1
        );
    }

    /**
     */
    public function testCreateTerminalOrder(): void {
        $testId = 'boarding.processing_accounts.create_terminal_order.0';
        $this->client->boarding->processingAccounts->createTerminalOrder(
            '38765',
            new CreateTerminalOrder([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'trainingProvider' => TrainingProvider::Payroc->value,
                'shipping' => new CreateTerminalOrderShipping([
                    'preferences' => new CreateTerminalOrderShippingPreferences([
                        'method' => CreateTerminalOrderShippingPreferencesMethod::NextDay->value,
                        'saturdayDelivery' => true,
                    ]),
                    'address' => new CreateTerminalOrderShippingAddress([
                        'recipientName' => 'Recipient Name',
                        'businessName' => 'Company Ltd',
                        'addressLine1' => '1 Example Ave.',
                        'addressLine2' => 'Example Address Line 2',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'postalCode' => '60056',
                        'email' => 'example@mail.com',
                        'phone' => '2025550164',
                    ]),
                ]),
                'orderItems' => [
                    new OrderItem([
                        'type' => OrderItemType::Solution->value,
                        'solutionTemplateId' => 'Roc Services_DX8000',
                        'solutionQuantity' => 1,
                        'deviceCondition' => OrderItemDeviceCondition::New_->value,
                        'solutionSetup' => new OrderItemSolutionSetup([
                            'timezone' => SchemasTimezone::AmericaChicago->value,
                            'industryTemplateId' => 'Retail',
                            'gatewaySettings' => new OrderItemSolutionSetupGatewaySettings([
                                'merchantPortfolioId' => 'Company Ltd',
                                'merchantTemplateId' => 'Company Ltd Merchant Template',
                                'userTemplateId' => 'Company Ltd User Template',
                                'terminalTemplateId' => 'Company Ltd Terminal Template',
                            ]),
                            'applicationSettings' => new OrderItemSolutionSetupApplicationSettings([
                                'clerkPrompt' => false,
                                'security' => new OrderItemSolutionSetupApplicationSettingsSecurity([
                                    'refundPassword' => true,
                                    'keyedSalePassword' => false,
                                    'reversalPassword' => true,
                                ]),
                            ]),
                            'deviceSettings' => new OrderItemSolutionSetupDeviceSettings([
                                'numberOfMobileUsers' => 2,
                                'communicationType' => OrderItemSolutionSetupDeviceSettingsCommunicationType::Wifi->value,
                            ]),
                            'batchClosure' => OrderItemSolutionSetupBatchClosure::automatic(new AutomaticBatchClose([])),
                            'receiptNotifications' => new OrderItemSolutionSetupReceiptNotifications([
                                'emailReceipt' => true,
                                'smsReceipt' => false,
                            ]),
                            'taxes' => [
                                new OrderItemSolutionSetupTaxesItem([
                                    'taxRate' => 6,
                                    'taxLabel' => 'Sales Tax',
                                ]),
                            ],
                            'tips' => new OrderItemSolutionSetupTips([
                                'enabled' => false,
                            ]),
                            'tokenization' => true,
                        ]),
                    ]),
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.create_terminal_order.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-accounts/38765/terminal-orders",
            null,
            1
        );
    }

    /**
     */
    public function testListProcessingTerminals(): void {
        $testId = 'boarding.processing_accounts.list_processing_terminals.0';
        $this->client->boarding->processingAccounts->listProcessingTerminals(
            '38765',
            new ListProcessingTerminalsProcessingAccountsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.processing_accounts.list_processing_terminals.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/processing-accounts/38765/processing-terminals",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    protected function setUp(): void {
        parent::setUp();
        $this->client = new PayrocClient(
            apiKey: 'test-apiKey',
            environment: Environments::custom('http://localhost:8080', 'http://localhost:8080'),
        );
    }
}
