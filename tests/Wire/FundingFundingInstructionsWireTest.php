<?php

namespace Payroc\Tests;

use Payroc\Tests\Wire\WireMockTestCase;
use Payroc\PayrocClient;
use Payroc\Funding\FundingInstructions\Requests\ListFundingInstructionsRequest;
use DateTime;
use Payroc\Funding\FundingInstructions\Requests\CreateFundingInstructionsRequest;
use Payroc\Types\Instruction;
use Payroc\Funding\FundingInstructions\Requests\UpdateFundingInstructionsRequest;
use Payroc\Environments;

class FundingFundingInstructionsWireTest extends WireMockTestCase
{
    /**
     * @var PayrocClient $client
     */
    private PayrocClient $client;

    /**
     */
    public function testList_(): void {
        $testId = 'funding.funding_instructions.list_.0';
        $this->client->funding->fundingInstructions->list(
            new ListFundingInstructionsRequest([
                'before' => '2571',
                'after' => '8516',
                'limit' => 1,
                'dateFrom' => new DateTime('2024-07-01'),
                'dateTo' => new DateTime('2024-07-03'),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_instructions.list_.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-instructions",
            ['before' => '2571', 'after' => '8516', 'limit' => '1', 'dateFrom' => '2024-07-01', 'dateTo' => '2024-07-03'],
            1
        );
    }

    /**
     */
    public function testCreate(): void {
        $testId = 'funding.funding_instructions.create.0';
        $this->client->funding->fundingInstructions->create(
            new CreateFundingInstructionsRequest([
                'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
                'body' => new Instruction([]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_instructions.create.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "POST",
            "/funding-instructions",
            null,
            1
        );
    }

    /**
     */
    public function testRetrieve(): void {
        $testId = 'funding.funding_instructions.retrieve.0';
        $this->client->funding->fundingInstructions->retrieve(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_instructions.retrieve.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "GET",
            "/funding-instructions/1",
            null,
            1
        );
    }

    /**
     */
    public function testUpdate(): void {
        $testId = 'funding.funding_instructions.update.0';
        $this->client->funding->fundingInstructions->update(
            1,
            new UpdateFundingInstructionsRequest([
                'body' => new Instruction([]),
            ]),
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_instructions.update.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "PUT",
            "/funding-instructions/1",
            null,
            1
        );
    }

    /**
     */
    public function testDelete(): void {
        $testId = 'funding.funding_instructions.delete.0';
        $this->client->funding->fundingInstructions->delete(
            1,
            [
                'headers' => [
                    'X-Test-Id' => 'funding.funding_instructions.delete.0',
                ],
            ],
        );
        $this->verifyRequestCount(
            $testId,
            "DELETE",
            "/funding-instructions/1",
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
