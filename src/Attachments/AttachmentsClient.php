<?php

namespace Payroc\Attachments;

use Psr\Http\Client\ClientInterface;
use Payroc\Core\Client\RawClient;
use Payroc\Environments;
use Payroc\Attachments\Requests\UploadAttachment;
use Payroc\Attachments\Types\Attachment;
use Payroc\Exceptions\PayrocException;
use Payroc\Exceptions\PayrocApiException;
use Payroc\Core\Multipart\MultipartFormData;
use Payroc\Core\Multipart\MultipartApiRequest;
use Payroc\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Payroc\Core\Json\JsonApiRequest;

class AttachmentsClient
{
    /**
     * @var array{
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options @phpstan-ignore-next-line Property is used in endpoint methods via HttpEndpointGenerator
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @var Environments $environment
     */
    private Environments $environment;

    /**
     * @param RawClient $client
     * @param Environments $environment
     */
    public function __construct(
        RawClient $client,
        Environments $environment,
    ) {
        $this->client = $client;
        $this->environment = $environment;
        $this->options = [];
    }

    /**
     * > Before you upload an attachment, make sure that you follow local privacy regulations and get the merchant's consent to process their information.
     *
     * **Note:** You need the ID of the processing account before you can upload an attachment. If you don't know the processingAccountId, go to the [Retrieve a Merchant Platform](https://docs.payroc.com/api/schema/boarding/merchant-platforms/retrieve) method.
     *
     * The attachment must be an uncompressed file under 30MB in one of the following formats:
     * - .bmp, csv, .doc, .docx, .gif, .htm, .html, .jpg, .jpeg, .msg, .pdf, .png, .ppt, .pptx, .tif, .tiff, .txt, .xls, .xlsx
     *
     * In the request, include the attachment that you want to upload and the following information about the attachment:
     * - **type** - Type of attachment that you want to upload.
     * - **description** - Short description of the attachment.
     *
     * In the response, our gateway returns information about the attachment including its upload status and an attachmentId that you can use to [Retrieve the details of the Attachment](https://docs.payroc.com/api/schema/attachments/retrieve).
     *
     * @param string $processingAccountId Unique identifier that we assigned to the processing account.
     * @param UploadAttachment $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     * } $options
     * @return ?Attachment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function uploadToProcessingAccount(string $processingAccountId, UploadAttachment $request, ?array $options = null): ?Attachment
    {
        $options = array_merge($this->options, $options ?? []);
        $headers = [];
        $headers['Idempotency-Key'] = $request->idempotencyKey;
        $body = new MultipartFormData();
        $body->add(name: 'attachment', value: $request->attachment->toJson());
        $body->addPart($request->file->toMultipartFormDataPart('file'));
        try {
            $response = $this->client->sendRequest(
                new MultipartApiRequest(
                    baseUrl: $this->environment->api,
                    path: "processing-accounts/{$processingAccountId}/attachments",
                    method: HttpMethod::POST,
                    headers: $headers,
                    body: $body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Attachment::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Use this method to retrieve the details of an attachment.
     *
     * To retrieve the details of an attachment you need its attachmentId. Our gateway returned the attachmentId in the response of the [Upload Attachment to Processing Account](https://docs.payroc.com/api/schema/boarding/processing-accounts/upload-to-processing-account) method.
     *
     * Our gateway returns information about the attachment, including its upload status and the entity that the attachment is linked to. Our gateway doesn't return the file that you uploaded.
     *
     * @param string $attachmentId Unique identifier of the attachment.
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Attachment
     * @throws PayrocException
     * @throws PayrocApiException
     */
    public function retrieve(string $attachmentId, ?array $options = null): ?Attachment
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->api,
                    path: "attachments/{$attachmentId}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Attachment::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new PayrocException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new PayrocException(message: $e->getMessage(), previous: $e);
        }
        throw new PayrocApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
