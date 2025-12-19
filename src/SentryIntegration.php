<?php

namespace Payroc;

/**
 * Sentry integration for error tracking and monitoring.
 *
 * Users can opt-out by setting the PAYROC_DISABLE_SENTRY environment variable
 * to 'true', '1', or 'yes'.
 */
class SentryIntegration
{
    private const DSN = 'https://2cb20901a329e8c1a486f52e646fffdc@o4505201678483456.ingest.us.sentry.io/4510516958920704';

    private const SENSITIVE_HEADERS = [
        'Authorization',
        'authorization',
        'X-API-Key',
        'x-api-key',
        'API-Key',
        'api-key',
        'Token',
        'token',
        'Auth-Token',
        'auth-token',
        'Access-Token',
        'access-token',
        'Client-Secret',
        'client-secret',
        'Secret',
        'secret',
    ];

    private const SENSITIVE_EXTRA_KEYWORDS = ['token', 'key', 'secret', 'auth', 'password'];

    private const BEARER_PATTERN = '/(Authorization[\'"]?\s*:\s*[\'"]?Bearer\s+)[^\s\'"]+/i';
    private const X_API_KEY_PATTERN = '/(x-api-key[\'"]?\s*:\s*[\'"]?)[^\s\'"]+/i';
    private const API_KEY_PATTERN = '/(api[_-]?key[\'"]?\s*[:=]\s*[\'"]?)[^\s\'"]+/i';

    private const REDACTED = '[REDACTED]';

    private static bool $initialized = false;

    /**
     * Initialize Sentry for error tracking and monitoring.
     */
    public static function initialize(): void
    {
        if (self::$initialized) {
            return;
        }

        if (self::isDisabled()) {
            return;
        }

        if (!class_exists('\Sentry\SentrySdk')) {
            return;
        }

        try {
            \Sentry\init([
                'dsn' => self::DSN,
                // DO NOT send PII to protect user privacy and credentials
                'send_default_pii' => false,
                // Set traces_sample_rate to 1.0 to capture 100% of transactions for tracing
                'traces_sample_rate' => 1.0,
                // Set release version for better tracking
                'release' => self::getSdkVersion(),
                // Configure environment
                'environment' => $_ENV['PAYROC_ENVIRONMENT'] ?? getenv('PAYROC_ENVIRONMENT') ?: 'production',
                // Filter sensitive data before sending to Sentry
                'before_send' => [self::class, 'beforeSend'],
            ]);

            self::$initialized = true;
        } catch (\Throwable $e) {
            // Initialization error - don't break SDK
        }
    }

    /**
     * Check if Sentry integration is disabled via environment variable.
     */
    private static function isDisabled(): bool
    {
        $disableSentry = $_ENV['PAYROC_DISABLE_SENTRY'] ?? getenv('PAYROC_DISABLE_SENTRY');

        if (!is_string($disableSentry) || $disableSentry === '') {
            return false;
        }

        return in_array(strtolower($disableSentry), ['true', '1', 'yes'], true);
    }

    /**
     * Filter sensitive data before sending to Sentry.
     *
     * @param \Sentry\Event $event
     * @param \Sentry\EventHint|null $hint
     * @return \Sentry\Event|null
     */
    public static function beforeSend(\Sentry\Event $event, ?\Sentry\EventHint $hint): ?\Sentry\Event
    {
        self::redactRequestHeaders($event);
        self::redactExceptionMessages($event);
        self::redactExtraContext($event);

        return $event;
    }

    /**
     * Redact sensitive headers from the request.
     */
    private static function redactRequestHeaders(\Sentry\Event $event): void
    {
        $request = $event->getRequest();
        if (!isset($request['headers']) || !is_array($request['headers'])) {
            return;
        }

        $headers = $request['headers'];
        foreach (self::SENSITIVE_HEADERS as $header) {
            if (array_key_exists($header, $headers)) {
                $headers[$header] = self::REDACTED;
            }
        }

        $request['headers'] = $headers;
        $event->setRequest($request);
    }

    /**
     * Redact sensitive data from exception messages.
     */
    private static function redactExceptionMessages(\Sentry\Event $event): void
    {
        $exceptions = $event->getExceptions();
        if (empty($exceptions)) {
            return;
        }

        foreach ($exceptions as $exception) {
            $value = $exception->getValue();
            if ($value === '') {
                continue;
            }

            $value = preg_replace(self::BEARER_PATTERN, '${1}' . self::REDACTED, $value) ?? $value;
            $value = preg_replace(self::X_API_KEY_PATTERN, '${1}' . self::REDACTED, $value) ?? $value;
            $value = preg_replace(self::API_KEY_PATTERN, '${1}' . self::REDACTED, $value) ?? $value;

            $exception->setValue($value);
        }
    }

    /**
     * Redact sensitive data from extra context.
     */
    private static function redactExtraContext(\Sentry\Event $event): void
    {
        $extra = $event->getExtra();
        if (empty($extra)) {
            return;
        }

        foreach ($extra as $key => $value) {
            $lowerKey = strtolower((string)$key);
            foreach (self::SENSITIVE_EXTRA_KEYWORDS as $sensitive) {
                if (str_contains($lowerKey, $sensitive)) {
                    $extra[$key] = self::REDACTED;
                    break;
                }
            }
        }

        $event->setExtra($extra);
    }

    /**
     * Get the SDK version string.
     */
    private static function getSdkVersion(): string
    {
        return 'payroc-php-sdk@0.0.913';
    }
}

// Auto-initialize Sentry when the file is loaded
SentryIntegration::initialize();
