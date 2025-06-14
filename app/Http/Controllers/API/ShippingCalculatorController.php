<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingCalculatorResource;
use App\Http\Requests\API\ShippingCalculatorRequest;
use App\Http\Controllers\API\Traits\ApiResponseTrait;
use App\Services\ShippingCalculatorService;

class ShippingCalculatorController extends Controller
{
    use ApiResponseTrait;
    protected $shippingService;
    public function __construct(ShippingCalculatorService $shippingService)
    {
        $this->shippingService = $shippingService;
    }


    public function calculate(ShippingCalculatorRequest $request)
    {

        $result = $this->shippingService->calculate($request->validated());


        return $this->ApiResponse(new ShippingCalculatorResource($result), 'Shipping cost calculated successfully', 200);
    }
}
