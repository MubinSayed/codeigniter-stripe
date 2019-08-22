<?php

namespace Stripe;

/**
 * Class ExchangeRate.
 */
class ExchangeRate extends ApiResource
{
    const OBJECT_NAME = 'exchange_rate';

    use ApiOperations\All;
    use ApiOperations\Retrieve;
}
