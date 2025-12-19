<?php

namespace Payroc\Tests\Integration\CardPayments\Refunds;

use Payroc\Tests\Integration\IntegrationTestCase;
use Payroc\CardPayments\Refunds\Requests\UnreferencedRefund;
use Payroc\CardPayments\Refunds\Types\UnreferencedRefundChannel;
use Payroc\Types\RefundOrder;
use Payroc\Types\Currency;
use Payroc\CardPayments\Refunds\Types\UnreferencedRefundRefundMethod;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\KeyedCardDetails;
use Payroc\Types\KeyedCardDetailsKeyedData;
use Payroc\Types\PlainTextKeyedDataFormat;
use Payroc\Types\Device;
use Payroc\Types\DeviceModel;

class CreateTest extends IntegrationTestCase
{
    public function testSmokeTest(): void
    {
        $createRefundRequest = new UnreferencedRefund([
            'idempotencyKey' => $this->generateUuid(),
            'channel' => UnreferencedRefundChannel::Pos->value,
            'processingTerminalId' => self::$terminalIdAvs,
            'order' => new RefundOrder([
                'amount' => 4999,
                'currency' => Currency::Usd->value,
                'orderId' => 'OrderRef6543',
                'description' => 'Large Pepperoni Pizza',
            ]),
            'refundMethod' => UnreferencedRefundRefundMethod::card(new CardPayload([
                'cardDetails' => CardPayloadCardDetails::keyed(new KeyedCardDetails([
                    'keyedData' => KeyedCardDetailsKeyedData::plainText(new PlainTextKeyedDataFormat([
                        'device' => new Device([
                            'model' => DeviceModel::PaxA920->value,
                            'serialNumber' => '1850010868',
                        ]),
                        'cardNumber' => '4539858876047062',
                        'expiryDate' => '1225',
                    ])),
                ])),
            ])),
        ]);

        $createdRefundResponse = self::$paymentsClient->cardPayments->refunds->createUnreferencedRefund($createRefundRequest);

        $this->assertEquals('ready', $createdRefundResponse->transactionResult->status);
    }

    private function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
