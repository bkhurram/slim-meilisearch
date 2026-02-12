<?php

declare(strict_types=1);

namespace App\Core;

use Negotiation\LanguageNegotiator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocalizationMiddleware implements MiddlewareInterface
{
    use NegotiationTrait;

    /**
     * Creates a new middleware instance.
     *
     * @param array<string> $languages Defines available languages.
     */
    public function __construct(
        private readonly array $languages
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $locale = $this->detectFromHeader($request);
        $request = $request->withAttribute('locale', $locale); // Attach locale attribute to the request
        $response = $handler->handle($request);

        if (!$response->hasHeader('Content-Language')) {
            return $response->withHeader('Content-Language', (string) $locale);
        }

        return $response;
    }

    /**
     * Returns the format using the Accept-Language header.
     */
    private function detectFromHeader(ServerRequestInterface $request): ?string
    {
        $accept = $request->getHeaderLine('Accept-Language');
        $locale = $this->negotiateHeader($accept, new LanguageNegotiator(), $this->languages);

        if (empty($locale)) {
            return $this->languages[0] ?? null;
        }

        return $locale;
    }
}
