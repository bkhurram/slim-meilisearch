<?php

declare(strict_types=1);

namespace App\Core;

use Negotiation\AbstractNegotiator;
use Negotiation\BaseAccept;
use Throwable;

/**
 * Common functions used by all negotiation middlewares.
 *
 * Copied from the package `middlewares/negotiation`
 *
 * @link https://github.com/middlewares/negotiation/blob/master/src/NegotiationTrait.php
 */
trait NegotiationTrait
{
    /**
     * Returns the best value of a header.
     *
     * @param array<string> $priorities
     */
    private function negotiateHeader(string $accept, AbstractNegotiator $negotiator, array $priorities): ?string
    {
        try {
            $best = $negotiator->getBest($accept, $priorities);

            return $best instanceof BaseAccept ? $best->getValue() : null;
        } catch (Throwable) {
            return null;
        }
    }
}
