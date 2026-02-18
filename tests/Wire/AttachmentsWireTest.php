<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Attachments\Requests\UploadAttachment;
use Payroc\Utils\File;
use Payroc\Attachments\Types\UploadToProcessingAccountAttachmentsRequestAttachment;
use Payroc\Attachments\Types\UploadToProcessingAccountAttachmentsRequestAttachmentType;
use Payroc\Environments;

class AttachmentsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testUploadToProcessingAccount(): void {
        $testId = 'attachments.upload_to_processing_account.0';
        $this->client->attachments->uploadToProcessingAccount(
            '38765',
            new UploadAttachment([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'file' => File::createFromString("example_file", "example_file"),
                'attachment' => new UploadToProcessingAccountAttachmentsRequestAttachment([
                    'type' => UploadToProcessingAccountAttachmentsRequestAttachmentType::BankingEvidence->value,
                ]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'attachments.upload_to_processing_account.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/processing-accounts/38765/attachments",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'attachments.retrieve.0';
        $this->client->attachments->retrieve(
            '12876',
            [
                'headers' => [
                    'X-Test-Id' => 'attachments.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/attachments/12876",
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
