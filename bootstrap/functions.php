<?php

use App\Services\Customer;

/**
 * @return Customer
 */
function customer()
{
    return Customer::getInstanse();
}
