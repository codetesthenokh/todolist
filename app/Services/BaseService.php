<?php

namespace App\Services;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BaseService
{
    protected $client; // = new Client(['base_uri' => 'http://localhost:4000/api/']);
    public function __construct() {
        $this->client = new Client(['base_uri' => 'http://localhost:4000/api/']);
    }
}