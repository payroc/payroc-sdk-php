# Payroc API PHP SDK

The Payroc API PHP SDK provides convenient access to the Payroc API from PHP.

## Contents

- [Payroc API PHP SDK](#payroc-api-php-sdk)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Usage](#usage)
    - [API Key](#api-key)
    - [PayrocClient](#payrocclient)
      - [Advanced Usage with Custom Environment](#advanced-usage-with-custom-environment)
  - [Exception Handling](#exception-handling)
  - [Logging](#logging)
  - [Pagination](#pagination)
    - [Pagination Gotcha](#pagination-gotcha)
  - [Polymorphic Types](#polymorphic-types)
    - [Creating Polymorphic Data](#creating-polymorphic-data)
    - [Handling Polymorphic Data](#handling-polymorphic-data)
  - [Advanced](#advanced)
    - [Custom Client](#custom-client)
    - [Retries](#retries)
    - [Timeouts](#timeouts)
  - [Contributing](#contributing)
  - [References](#references)

## Requirements

This SDK requires PHP ^8.1.

## Installation

```sh
composer require payroc/payroc
```

## Usage

### API Key

You need to provide your API Key to the `PayrocClient` constructor. In this example we read it from an environment variable named `PAYROC_API_KEY`. In your own code you should consider security and compliance best practices, likely retrieving this value from a secure vault on demand.

### PayrocClient

Instantiate and use the client with the following:

```php
<?php

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

$apiKey = getenv('PAYROC_API_KEY') ?: throw new Exception('Payroc API Key not found');
$client = new PayrocClient(
    apiKey: $apiKey,
    environment: Environments::Production()
);
$client->cardPayments->payments->create(
    new PaymentRequest([
        'idempotencyKey' => '8e03978e-40d5-43e8-bc93-6894a57f9324',
        'channel' => PaymentRequestChannel::Web->value,
        'processingTerminalId' => '1234001',
        'operator' => 'Jane',
        'order' => new PaymentOrderRequest([
            'orderId' => 'OrderRef6543',
            'description' => 'Large Pepperoni Pizza',
            'amount' => 4999,
            'currency' => Currency::Usd->value,
        ]),
        'customer' => new Customer([
            'firstName' => 'Sarah',
            'lastName' => 'Hopper',
            'billingAddress' => new Address([
                'address1' => '1 Example Ave.',
                'address2' => 'Example Address Line 2',
                'address3' => 'Example Address Line 3',
                'city' => 'Chicago',
                'state' => 'Illinois',
                'country' => 'US',
                'postalCode' => '60056',
            ]),
            'shippingAddress' => new Shipping([
                'recipientName' => 'Sarah Hopper',
                'address' => new Address([
                    'address1' => '1 Example Ave.',
                    'address2' => 'Example Address Line 2',
                    'address3' => 'Example Address Line 3',
                    'city' => 'Chicago',
                    'state' => 'Illinois',
                    'country' => 'US',
                    'postalCode' => '60056',
                ]),
            ]),
        ]),
        'paymentMethod' => PaymentRequestPaymentMethod::card(new CardPayload([
            'cardDetails' => CardPayloadCardDetails::raw(new RawCardDetails([
                'device' => new Device([
                    'model' => DeviceModel::BbposChp->value,
                    'serialNumber' => '1850010868',
                ]),
                'rawData' => 'A1B2C3D4E5F67890ABCD1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF',
            ])),
        ])),
        'customFields' => [
            new CustomField([
                'name' => 'yourCustomField',
                'value' => 'abc123',
            ]),
        ],
    ]),
);

```

### Advanced Usage with Custom Environment

If you wish to use the SDK against a custom URL, such as a mock API server, you can provide a custom environment to the `PayrocClient` constructor:

```php
<?php

use Payroc\PayrocClient;
use Payroc\Environments;

$apiKey = getenv('PAYROC_API_KEY') ?: throw new Exception('Payroc API Key not found');
$mockEnvironment = Environments::custom(
    api: 'http://localhost:3000',
    identity: 'http://localhost:3001'
);

$client = new PayrocClient(
    apiKey: $apiKey,
    environment: $mockEnvironment
);
```

## Exception Handling

When the API returns a non-success status code (4xx or 5xx response), a subclass of the following error will be thrown.

```php
use Payroc\Exceptions\PayrocApiException;

try {
    $response = $client->cardPayments->payments->create(...);
} catch (PayrocApiException $e) {
    echo $e->getBody();
    echo $e->getStatusCode();
}
```

## Logging

> [!WARNING]  
> Be careful when configuring your logging not to log the headers of outbound HTTP requests, lest you leak an API key or access token.

## Pagination

List endpoints return a `Pager<T>` which lets you loop over all items and the SDK will automatically make multiple HTTP requests for you.

```php
use Payroc\PayrocClient;
use Payroc\Environments;
use Payroc\CardPayments\Payments\Requests\ListPaymentsRequest;

$apiKey = getenv('PAYROC_API_KEY') ?: throw new Exception('Payroc API Key not found');
$client = new PayrocClient(
    apiKey: $apiKey,
    environment: Environments::Production()
);

$items = $client->cardPayments->payments->list(new ListPaymentsRequest([
    'processingTerminalId' => '1234001',
    'limit' => 10
]));

foreach ($items as $item) {
    var_dump($item);
}
```

You can also iterate page-by-page:

```php
foreach ($items->getPages() as $page) {
    foreach ($page->getItems() as $pageItem) {
        var_dump($pageItem);
    }
}
```

### Pagination Gotcha

Beware of iterating the items on a single page and thinking that they are all there are. In the following example, there are only the first page of items, because this is iterating the items on a single page:

```php
$pager = $client->cardPayments->payments->list(new ListPaymentsRequest([
    'processingTerminalId' => '1234001'
]));

$ids = [];

// This only gets the first page
$firstPage = $pager->getPages()->current();
foreach ($firstPage->getItems() as $payment) {
    $ids[] = $payment->paymentId;
}
```

This might be helpful when you only want to process the first few results, but to iterate all items, the standard `foreach` approach is recommended.

## Polymorphic Types

Our API makes frequent use of polymorphic data structures. This is when a value might be one of multiple types, and the type is determined at runtime. For example, a payment method can be one of several types, such as `card`, `secureToken`, `digitalWallet`, or `singleUseToken`. Similarly, card details can have different entry methods like `raw`, `icc`, `keyed`, or `swiped`.

### Creating Polymorphic Data

The SDK provides static factory methods on each polymorphic type to create instances of specific variants. This pattern keeps your code clean and type-safe.

For example, to create a payment method with a card:

```php
use Payroc\CardPayments\Payments\Types\PaymentRequestPaymentMethod;
use Payroc\Types\CardPayload;
use Payroc\Types\CardPayloadCardDetails;
use Payroc\Types\RawCardDetails;

$paymentMethod = PaymentRequestPaymentMethod::card(new CardPayload([
    'cardDetails' => CardPayloadCardDetails::raw(new RawCardDetails([
        'device' => new Device([
            'model' => DeviceModel::BbposChp->value,
            'serialNumber' => '1850010868',
        ]),
        'rawData' => 'A1B2C3D4E5F67890ABCD1234567890ABCDEF1234567890ABCDEF1234567890ABCDEF',
    ])),
]));
```

Or to create a payment method with a secure token:

```php
use Payroc\CardPayments\Payments\Types\PaymentRequestPaymentMethod;
use Payroc\Types\SecureTokenPayload;

$paymentMethod = PaymentRequestPaymentMethod::secureToken(new SecureTokenPayload([
    'token' => 'tok_abc123...',
]));
```

Each polymorphic type provides factory methods for all its variants:

- `PaymentRequestPaymentMethod::card()`, `::secureToken()`, `::digitalWallet()`, `::singleUseToken()`
- `CardPayloadCardDetails::raw()`, `::icc()`, `::keyed()`, `::swiped()`

### Handling Polymorphic Data

When working with polymorphic types in API responses, the SDK provides several methods to inspect and extract the specific type:

```php
// Check the type using is* methods
if ($paymentMethod->isCard()) {
    // Extract the specific type using as* methods
    $card = $paymentMethod->asCard();
    // Now you can access card-specific properties
    echo $card->cardDetails->entryMethod;
}

// You can also check the type property directly
switch ($paymentMethod->type) {
    case 'card':
        $card = $paymentMethod->asCard();
        // Handle card payment
        break;
    case 'secureToken':
        $token = $paymentMethod->asSecureToken();
        // Handle secure token payment
        break;
    case 'digitalWallet':
        $wallet = $paymentMethod->asDigitalWallet();
        // Handle digital wallet payment
        break;
    case 'singleUseToken':
        $singleUse = $paymentMethod->asSingleUseToken();
        // Handle single use token payment
        break;
}
```

The `is*()` methods return a boolean indicating if the value is of that specific type, while the `as*()` methods extract and return the strongly-typed value. If you call an `as*()` method on the wrong type, it will throw an exception.

This pattern applies to all polymorphic types in the SDK, providing a consistent and type-safe way to work with variant data structures.

## Advanced

### Custom Client

This SDK is built to work with any HTTP client that implements Guzzle's `ClientInterface`.
By default, if no client is provided, the SDK will use Guzzle's default HTTP client.
However, you can pass your own client that adheres to `ClientInterface`:

```php
use Payroc\PayrocClient;

// Create a custom Guzzle client with specific configuration.
$customClient = new \GuzzleHttp\Client([
    'timeout' => 5.0,
]);

// Pass the custom client when creating an instance of the class.
$client = new PayrocClient(options: [
    'client' => $customClient
]);

// You can also utilize the same technique to leverage advanced customizations to the client such as adding middleware
$handlerStack = \GuzzleHttp\HandlerStack::create();
$handlerStack->push(MyCustomMiddleware::create());
$customClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

// Pass the custom client when creating an instance of the class.
$client = new PayrocClient(options: [
    'client' => $customClient
]);
```

### Retries

The SDK is instrumented with automatic retries with exponential backoff. A request will be retried as long
as the request is deemed retryable and the number of retry attempts has not grown larger than the configured
retry limit (default: 2).

A request is deemed retryable when any of the following HTTP status codes is returned:

- [408](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/408) (Timeout)
- [429](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/429) (Too Many Requests)
- [5XX](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/500) (Internal Server Errors)

Use the `maxRetries` request option to configure this behavior.

```php
$response = $client->cardPayments->payments->create(
    ...,
    options: [
        'maxRetries' => 0 // Override maxRetries at the request level
    ]
);
```

### Timeouts

The SDK defaults to a 30 second timeout. Use the `timeout` option to configure this behavior.

```php
$response = $client->cardPayments->payments->create(
    ...,
    options: [
        'timeout' => 3.0 // Override timeout to 3 seconds
    ]
);
```

## Contributing

While we value open-source contributions to this SDK, this library is generated programmatically.
Additions made directly to this library would have to be moved over to our generation code,
otherwise they would be overwritten upon the next generated release. Feel free to open a PR as
a proof of concept, but know that we will not be able to merge it as-is. We suggest opening
an issue first to discuss with us!

On the other hand, contributions to the README are always very welcome!

For details on setting up your development environment, running tests, and code quality standards, please see [CONTRIBUTING.md](./CONTRIBUTING.md).

## References

The Payroc API SDK is generated via [Fern](https://www.buildwithfern.com/).

[![fern shield](https://img.shields.io/badge/%F0%9F%8C%BF-Built%20with%20Fern-brightgreen)](https://buildwithfern.com?utm_source=github&utm_medium=github&utm_campaign=readme&utm_source=https%3A%2F%2Fgithub.com%2Fpayroc%2Fpayroc-sdk-php)
