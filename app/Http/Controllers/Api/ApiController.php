<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponderTrait;

class ApiController extends Controller
{
    use ApiResponderTrait;

    const PER_PAGE = 20;
}
