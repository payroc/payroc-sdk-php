<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Boarding\MerchantPlatforms\Requests\ListMerchantPlatformsRequest;
use Payroc\Boarding\MerchantPlatforms\Requests\CreateMerchantAccount;
use Payroc\Types\Business;
use Payroc\Types\BusinessOrganizationType;
use Payroc\Types\BusinessCountryOfOperation;
use Payroc\Types\LegalAddress;
use Payroc\Types\AddressTypeType;
use Payroc\Types\ContactMethod;
use Payroc\Types\ContactMethodEmail;
use Payroc\Types\CreateProcessingAccount;
use Payroc\Types\Owner;
use DateTime;
use Payroc\Types\Address;
use Payroc\Types\Identifier;
use Payroc\Types\IdentifierType;
use Payroc\Types\OwnerRelationship;
use Payroc\Types\CreateProcessingAccountBusinessType;
use Payroc\Types\Timezone;
use Payroc\Types\Processing;
use Payroc\Types\ProcessingTransactionAmounts;
use Payroc\Types\ProcessingMonthlyAmounts;
use Payroc\Types\ProcessingVolumeBreakdown;
use Payroc\Types\ProcessingMonthsOfOperationItem;
use Payroc\Types\ProcessingAch;
use Payroc\Types\ProcessingAchRefunds;
use Payroc\Types\ProcessingAchLimits;
use Payroc\Types\ProcessingAchTransactionTypesItem;
use Payroc\Types\ProcessingCardAcceptance;
use Payroc\Types\ProcessingCardAcceptanceCardsAcceptedItem;
use Payroc\Types\ProcessingCardAcceptanceSpecialityCards;
use Payroc\Types\ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect;
use Payroc\Types\ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer;
use Payroc\Types\ProcessingCardAcceptanceSpecialityCardsOther;
use Payroc\Types\CreateFunding;
use Payroc\Types\CommonFundingFundingSchedule;
use Payroc\Types\FundingAccount;
use Payroc\Types\FundingAccountType;
use Payroc\Types\FundingAccountUse;
use Payroc\Types\PaymentMethodsItem;
use Payroc\Types\PaymentMethodAch;
use Payroc\Types\Pricing;
use Payroc\Types\PricingTemplate;
use Payroc\Types\Signature;
use Payroc\Types\SignatureByDirectLink;
use Payroc\Types\Contact;
use Payroc\Types\ContactType;
use Payroc\Boarding\MerchantPlatforms\Requests\ListBoardingMerchantPlatformProcessingAccountsRequest;
use Payroc\Boarding\MerchantPlatforms\Requests\CreateProcessingAccountMerchantPlatformsRequest;
use Payroc\Environments;

class BoardingMerchantPlatformsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'boarding.merchant_platforms.list_.0';
        $this->client->boarding->merchantPlatforms->list(
            new ListMerchantPlatformsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.merchant_platforms.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/merchant-platforms",
            ['before' => '2571', 'after' => '8516', 'limit' => '1'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'boarding.merchant_platforms.create.0';
        $this->client->boarding->merchantPlatforms->create(
            new CreateMerchantAccount([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'business' => new Business([
                    'name' => 'Example Corp',
                    'taxId' => '12-3456789',
                    'organizationType' => BusinessOrganizationType::PrivateCorporation->value,
                    'countryOfOperation' => BusinessCountryOfOperation::Us->value,
                    'addresses' => [
                        new LegalAddress([
                            'address1' => '1 Example Ave.',
                            'address2' => 'Example Address Line 2',
                            'address3' => 'Example Address Line 3',
                            'city' => 'Chicago',
                            'state' => 'Illinois',
                            'country' => 'US',
                            'postalCode' => '60056',
                            'type' => AddressTypeType::LegalAddress->value,
                        ]),
                    ],
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                ]),
                'processingAccounts' => [
                    new CreateProcessingAccount([
                        'doingBusinessAs' => 'Pizza Doe',
                        'owners' => [
                            new Owner([
                                'firstName' => 'Jane',
                                'middleName' => 'Helen',
                                'lastName' => 'Doe',
                                'dateOfBirth' => new DateTime('1964-03-22'),
                                'address' => new Address([
                                    'address1' => '1 Example Ave.',
                                    'address2' => 'Example Address Line 2',
                                    'address3' => 'Example Address Line 3',
                                    'city' => 'Chicago',
                                    'state' => 'Illinois',
                                    'country' => 'US',
                                    'postalCode' => '60056',
                                ]),
                                'identifiers' => [
                                    new Identifier([
                                        'type' => IdentifierType::NationalId->value,
                                        'value' => '000-00-4320',
                                    ]),
                                ],
                                'contactMethods' => [
                                    ContactMethod::email(new ContactMethodEmail([
                                        'value' => 'jane.doe@example.com',
                                    ])),
                                ],
                                'relationship' => new OwnerRelationship([
                                    'equityPercentage' => 48.5,
                                    'title' => 'CFO',
                                    'isControlProng' => true,
                                    'isAuthorizedSignatory' => false,
                                ]),
                            ]),
                        ],
                        'website' => 'www.example.com',
                        'businessType' => CreateProcessingAccountBusinessType::Restaurant->value,
                        'categoryCode' => 5999,
                        'merchandiseOrServiceSold' => 'Pizza',
                        'businessStartDate' => new DateTime('2020-01-01'),
                        'timezone' => Timezone::AmericaChicago->value,
                        'address' => new Address([
                            'address1' => '1 Example Ave.',
                            'address2' => 'Example Address Line 2',
                            'address3' => 'Example Address Line 3',
                            'city' => 'Chicago',
                            'state' => 'Illinois',
                            'country' => 'US',
                            'postalCode' => '60056',
                        ]),
                        'contactMethods' => [
                            ContactMethod::email(new ContactMethodEmail([
                                'value' => 'jane.doe@example.com',
                            ])),
                        ],
                        'processing' => new Processing([
                            'transactionAmounts' => new ProcessingTransactionAmounts([
                                'average' => 5000,
                                'highest' => 10000,
                            ]),
                            'monthlyAmounts' => new ProcessingMonthlyAmounts([
                                'average' => 50000,
                                'highest' => 100000,
                            ]),
                            'volumeBreakdown' => new ProcessingVolumeBreakdown([
                                'cardPresent' => 77,
                                'mailOrTelephone' => 3,
                                'ecommerce' => 20,
                            ]),
                            'isSeasonal' => true,
                            'monthsOfOperation' => [
                                ProcessingMonthsOfOperationItem::Jan->value,
                                ProcessingMonthsOfOperationItem::Feb->value,
                            ],
                            'ach' => new ProcessingAch([
                                'naics' => '5812',
                                'previouslyTerminatedForAch' => false,
                                'refunds' => new ProcessingAchRefunds([
                                    'writtenRefundPolicy' => true,
                                    'refundPolicyUrl' => 'www.example.com/refund-poilcy-url',
                                ]),
                                'estimatedMonthlyTransactions' => 3000,
                                'limits' => new ProcessingAchLimits([
                                    'singleTransaction' => 10000,
                                    'dailyDeposit' => 200000,
                                    'monthlyDeposit' => 6000000,
                                ]),
                                'transactionTypes' => [
                                    ProcessingAchTransactionTypesItem::PrearrangedPayment->value,
                                    ProcessingAchTransactionTypesItem::Other->value,
                                ],
                                'transactionTypesOther' => 'anotherTransactionType',
                            ]),
                            'cardAcceptance' => new ProcessingCardAcceptance([
                                'debitOnly' => false,
                                'hsaFsa' => false,
                                'cardsAccepted' => [
                                    ProcessingCardAcceptanceCardsAcceptedItem::Visa->value,
                                    ProcessingCardAcceptanceCardsAcceptedItem::Mastercard->value,
                                ],
                                'specialityCards' => new ProcessingCardAcceptanceSpecialityCards([
                                    'americanExpressDirect' => new ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect([
                                        'enabled' => true,
                                        'merchantNumber' => 'abc1234567',
                                    ]),
                                    'electronicBenefitsTransfer' => new ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer([
                                        'enabled' => true,
                                        'fnsNumber' => '6789012',
                                    ]),
                                    'other' => new ProcessingCardAcceptanceSpecialityCardsOther([
                                        'wexMerchantNumber' => 'abc1234567',
                                        'voyagerMerchantId' => 'abc1234567',
                                        'fleetMerchantId' => 'abc1234567',
                                    ]),
                                ]),
                            ]),
                        ]),
                        'funding' => new CreateFunding([
                            'fundingSchedule' => CommonFundingFundingSchedule::Nextday->value,
                            'acceleratedFundingFee' => 1999,
                            'dailyDiscount' => false,
                            'fundingAccounts' => [
                                new FundingAccount([
                                    'type' => FundingAccountType::Checking->value,
                                    'use' => FundingAccountUse::CreditAndDebit->value,
                                    'nameOnAccount' => 'Jane Doe',
                                    'paymentMethods' => [
                                        PaymentMethodsItem::ach(new PaymentMethodAch([])),
                                    ],
                                    'metadata' => [
                                        'yourCustomField' => 'abc123',
                                    ],
                                ]),
                            ],
                        ]),
                        'pricing' => Pricing::intent(new PricingTemplate([
                            'pricingIntentId' => '6123',
                        ])),
                        'signature' => Signature::requestedViaDirectLink(new SignatureByDirectLink([])),
                        'contacts' => [
                            new Contact([
                                'type' => ContactType::Manager->value,
                                'firstName' => 'Jane',
                                'middleName' => 'Helen',
                                'lastName' => 'Doe',
                                'identifiers' => [
                                    new Identifier([
                                        'type' => IdentifierType::NationalId->value,
                                        'value' => '000-00-4320',
                                    ]),
                                ],
                                'contactMethods' => [
                                    ContactMethod::email(new ContactMethodEmail([
                                        'value' => 'jane.doe@example.com',
                                    ])),
                                ],
                            ]),
                        ],
                        'metadata' => [
                            'customerId' => '2345',
                        ],
                    ]),
                ],
                'metadata' => [
                    'customerId' => '2345',
                ],
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.merchant_platforms.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/merchant-platforms",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'boarding.merchant_platforms.retrieve.0';
        $this->client->boarding->merchantPlatforms->retrieve(
            '12345',
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.merchant_platforms.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/merchant-platforms/12345",
            null,
            1
        );
    }

    /**
     */
    public function testListProcessingAccounts(): void {
        $testId = 'boarding.merchant_platforms.list_processing_accounts.0';
        $this->client->boarding->merchantPlatforms->listProcessingAccounts(
            '12345',
            new ListBoardingMerchantPlatformProcessingAccountsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'includeClosed' => true,
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.merchant_platforms.list_processing_accounts.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/merchant-platforms/12345/processing-accounts",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'includeClosed' => 'true'],
            1
        );
    }

    /**
     */
    public function testCreateProcessingAccount(): void {
        $testId = 'boarding.merchant_platforms.create_processing_account.0';
        $this->client->boarding->merchantPlatforms->createProcessingAccount(
            '12345',
            new CreateProcessingAccountMerchantPlatformsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new CreateProcessingAccount([
                    'doingBusinessAs' => 'Pizza Doe',
                    'owners' => [
                        new Owner([
                            'firstName' => 'Jane',
                            'middleName' => 'Helen',
                            'lastName' => 'Doe',
                            'dateOfBirth' => new DateTime('1964-03-22'),
                            'address' => new Address([
                                'address1' => '1 Example Ave.',
                                'address2' => 'Example Address Line 2',
                                'address3' => 'Example Address Line 3',
                                'city' => 'Chicago',
                                'state' => 'Illinois',
                                'country' => 'US',
                                'postalCode' => '60056',
                            ]),
                            'identifiers' => [
                                new Identifier([
                                    'type' => IdentifierType::NationalId->value,
                                    'value' => '000-00-4320',
                                ]),
                            ],
                            'contactMethods' => [
                                ContactMethod::email(new ContactMethodEmail([
                                    'value' => 'jane.doe@example.com',
                                ])),
                            ],
                            'relationship' => new OwnerRelationship([
                                'equityPercentage' => 51.5,
                                'title' => 'CFO',
                                'isControlProng' => true,
                                'isAuthorizedSignatory' => false,
                            ]),
                        ]),
                    ],
                    'website' => 'www.example.com',
                    'businessType' => CreateProcessingAccountBusinessType::Restaurant->value,
                    'categoryCode' => 5999,
                    'merchandiseOrServiceSold' => 'Pizza',
                    'businessStartDate' => new DateTime('2020-01-01'),
                    'timezone' => Timezone::AmericaChicago->value,
                    'address' => new Address([
                        'address1' => '1 Example Ave.',
                        'address2' => 'Example Address Line 2',
                        'address3' => 'Example Address Line 3',
                        'city' => 'Chicago',
                        'state' => 'Illinois',
                        'country' => 'US',
                        'postalCode' => '60056',
                    ]),
                    'contactMethods' => [
                        ContactMethod::email(new ContactMethodEmail([
                            'value' => 'jane.doe@example.com',
                        ])),
                    ],
                    'processing' => new Processing([
                        'transactionAmounts' => new ProcessingTransactionAmounts([
                            'average' => 5000,
                            'highest' => 10000,
                        ]),
                        'monthlyAmounts' => new ProcessingMonthlyAmounts([
                            'average' => 50000,
                            'highest' => 100000,
                        ]),
                        'volumeBreakdown' => new ProcessingVolumeBreakdown([
                            'cardPresent' => 77,
                            'mailOrTelephone' => 3,
                            'ecommerce' => 20,
                        ]),
                        'isSeasonal' => true,
                        'monthsOfOperation' => [
                            ProcessingMonthsOfOperationItem::Jan->value,
                            ProcessingMonthsOfOperationItem::Feb->value,
                        ],
                        'ach' => new ProcessingAch([
                            'naics' => '5812',
                            'previouslyTerminatedForAch' => false,
                            'refunds' => new ProcessingAchRefunds([
                                'writtenRefundPolicy' => true,
                                'refundPolicyUrl' => 'www.example.com/refund-poilcy-url',
                            ]),
                            'estimatedMonthlyTransactions' => 3000,
                            'limits' => new ProcessingAchLimits([
                                'singleTransaction' => 10000,
                                'dailyDeposit' => 200000,
                                'monthlyDeposit' => 6000000,
                            ]),
                            'transactionTypes' => [
                                ProcessingAchTransactionTypesItem::PrearrangedPayment->value,
                                ProcessingAchTransactionTypesItem::Other->value,
                            ],
                            'transactionTypesOther' => 'anotherTransactionType',
                        ]),
                        'cardAcceptance' => new ProcessingCardAcceptance([
                            'debitOnly' => false,
                            'hsaFsa' => false,
                            'cardsAccepted' => [
                                ProcessingCardAcceptanceCardsAcceptedItem::Visa->value,
                                ProcessingCardAcceptanceCardsAcceptedItem::Mastercard->value,
                            ],
                            'specialityCards' => new ProcessingCardAcceptanceSpecialityCards([
                                'americanExpressDirect' => new ProcessingCardAcceptanceSpecialityCardsAmericanExpressDirect([
                                    'enabled' => true,
                                    'merchantNumber' => 'abc1234567',
                                ]),
                                'electronicBenefitsTransfer' => new ProcessingCardAcceptanceSpecialityCardsElectronicBenefitsTransfer([
                                    'enabled' => true,
                                    'fnsNumber' => '6789012',
                                ]),
                                'other' => new ProcessingCardAcceptanceSpecialityCardsOther([
                                    'wexMerchantNumber' => 'abc1234567',
                                    'voyagerMerchantId' => 'abc1234567',
                                    'fleetMerchantId' => 'abc1234567',
                                ]),
                            ]),
                        ]),
                    ]),
                    'funding' => new CreateFunding([
                        'fundingSchedule' => CommonFundingFundingSchedule::Nextday->value,
                        'acceleratedFundingFee' => 1999,
                        'dailyDiscount' => false,
                        'fundingAccounts' => [
                            new FundingAccount([
                                'type' => FundingAccountType::Checking->value,
                                'use' => FundingAccountUse::CreditAndDebit->value,
                                'nameOnAccount' => 'Jane Doe',
                                'paymentMethods' => [
                                    PaymentMethodsItem::ach(new PaymentMethodAch([])),
                                ],
                                'metadata' => [
                                    'yourCustomField' => 'abc123',
                                ],
                            ]),
                        ],
                    ]),
                    'pricing' => Pricing::intent(new PricingTemplate([
                        'pricingIntentId' => '6123',
                    ])),
                    'signature' => Signature::requestedViaDirectLink(new SignatureByDirectLink([])),
                    'contacts' => [
                        new Contact([
                            'type' => ContactType::Manager->value,
                            'firstName' => 'Jane',
                            'middleName' => 'Helen',
                            'lastName' => 'Doe',
                            'identifiers' => [
                                new Identifier([
                                    'type' => IdentifierType::NationalId->value,
                                    'value' => '000-00-4320',
                                ]),
                            ],
                            'contactMethods' => [
                                ContactMethod::email(new ContactMethodEmail([
                                    'value' => 'jane.doe@example.com',
                                ])),
                            ],
                        ]),
                    ],
                    'metadata' => [
                        'customerId' => '2345',
                    ],
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'boarding.merchant_platforms.create_processing_account.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/merchant-platforms/12345/processing-accounts",
            null,
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
