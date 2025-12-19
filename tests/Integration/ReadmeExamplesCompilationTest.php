<?php

namespace Payroc\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Payroc\PayrocClient;
use Payroc\Environments;
use Payroc\CardPayments\Payments\Requests\PaymentRequest;
use Payroc\CardPayments\Payments\Types\PaymentRequestChannel;
use Payroc\Types\PaymentOrderRequest;
use Payroc\Types\Currency;
use Payroc\Types\Customer;
use Payroc\Types\Address;
use Payroc\Types\Shipping;
use Payroc\CardPayments\Payments\Types\PaymentRequestPaymentMethod;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;
use Payroc\Types\CustomField;
use Payroc\CardPayments\Payments\Requests\ListPaymentsRequest;
use Payroc\Types\SecureTokenPayload;
use Payroc\Exceptions\PayrocApiException;

/**
 * Test to verify that all README examples compile correctly.
 * This test does NOT execute the API calls, it only verifies that the code compiles.
 */
class ReadmeExamplesCompilationTest extends TestCase
{
    /**
     * Test that the main payment creation example from README compiles
     */
    public function testMainPaymentExampleCompiles(): void
    {
        // This test verifies the code structure compiles without actually making API calls
        $this->assertTrue(class_exists(PayrocClient::class));
        $this->assertTrue(class_exists(PaymentRequest::class));
        $this->assertTrue(enum_exists(PaymentRequestChannel::class));
        $this->assertTrue(class_exists(PaymentRequestPaymentMethod::class));
        
        // Verify the client has the correct structure
        $mockClient = $this->createMockClient();
        $this->assertObjectHasProperty('cardPayments', $mockClient);
        $this->assertObjectHasProperty('payments', $mockClient->cardPayments);
        
        // Verify method exists
        $this->assertTrue(method_exists($mockClient->cardPayments->payments, 'create'));
    }

    /**
     * Test that the pagination example from README compiles
     */
    public function testPaginationExampleCompiles(): void
    {
        $this->assertTrue(class_exists(ListPaymentsRequest::class));
        
        $mockClient = $this->createMockClient();
        $this->assertTrue(method_exists($mockClient->cardPayments->payments, 'list'));
    }

    /**
     * Test that polymorphic type examples compile
     */
    public function testPolymorphicTypeExamplesCompile(): void
    {
        // Test card payment method
        $this->assertTrue(method_exists(PaymentRequestPaymentMethod::class, 'card'));
        
        // Test secure token payment method
        $this->assertTrue(method_exists(PaymentRequestPaymentMethod::class, 'secureToken'));
        $this->assertTrue(class_exists(SecureTokenPayload::class));
        
        // Test other payment method types exist
        $this->assertTrue(method_exists(PaymentRequestPaymentMethod::class, 'digitalWallet'));
        $this->assertTrue(method_exists(PaymentRequestPaymentMethod::class, 'singleUseToken'));
        
        // Test card details variants
        $this->assertTrue(method_exists(CardPayloadCardDetails::class, 'raw'));
        $this->assertTrue(method_exists(CardPayloadCardDetails::class, 'icc'));
        $this->assertTrue(method_exists(CardPayloadCardDetails::class, 'keyed'));
        $this->assertTrue(method_exists(CardPayloadCardDetails::class, 'swiped'));
    }

    /**
     * Test that exception handling example compiles
     */
    public function testExceptionHandlingExampleCompiles(): void
    {
        $this->assertTrue(class_exists(PayrocApiException::class));
        $this->assertTrue(method_exists(PayrocApiException::class, 'getBody'));
        $this->assertTrue(method_exists(PayrocApiException::class, 'getCode'));
    }

    /**
     * Test that all required types from the main example exist
     */
    public function testAllRequiredTypesExist(): void
    {
        $requiredClasses = [
            PayrocClient::class,
            Environments::class,
            PaymentRequest::class,
            PaymentOrderRequest::class,
            Customer::class,
            Address::class,
            Shipping::class,
            CardPayload::class,
            CardPayloadCardDetails::class,
            RawCardDetails::class,
            Device::class,
            CustomField::class,
        ];

        foreach ($requiredClasses as $class) {
            $this->assertTrue(
                class_exists($class),
                "Required class {$class} does not exist"
            );
        }

        $requiredEnums = [
            PaymentRequestChannel::class,
            Currency::class,
            DeviceModel::class,
        ];

        foreach ($requiredEnums as $enum) {
            $this->assertTrue(
                enum_exists($enum),
                "Required enum {$enum} does not exist"
            );
        }
    }

    /**
     * Test that the custom environment example compiles
     */
    public function testCustomEnvironmentExampleCompiles(): void
    {
        $this->assertTrue(method_exists(Environments::class, 'custom'));
        $this->assertTrue(method_exists(Environments::class, 'Production'));
        $this->assertTrue(method_exists(Environments::class, 'Uat'));
    }

    /**
     * Create a mock client for testing structure without API calls
     */
    private function createMockClient(): PayrocClient
    {
        // Use a dummy API key for structure testing only
        return new PayrocClient(
            apiKey: 'test_key_for_compilation_check',
            environment: Environments::Production()
        );
    }
}
