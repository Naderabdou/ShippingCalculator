<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingCalculatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => 'Shipping Cost Result',
            'total_price' => number_format($this['total'], 2) . ' AED',
            'summary' => 'Total Shipping Cost',
            'breakdown' => [
                'Base Cost (' . $this['destination_type'] . ')' => number_format($this['details']['base_cost'], 2) . ' AED',
                'Volumetric Weight Used' => number_format($this['used_weight'], 2) . ' KG',
                'Extra Weight (' . number_format($this['extra_weight'], 1) . ' KG × 2 AED)' =>
                number_format($this['details']['extra_cost'], 2) . ' AED',
                'Subtotal 1' => number_format($this['subtotals']['before_fuel'], 2) . ' AED',
                'Fuel Surcharge (2%)' => number_format($this['details']['fuel_surcharge'], 2) . ' AED',
                'Subtotal 2' => number_format($this['subtotals']['before_packaging'], 2) . ' AED',
                'Packaging Cost' => number_format($this['details']['packaging_cost'], 2) . ' AED',
                'Subtotal 3' => number_format($this['subtotals']['before_epg'], 2) . ' AED',
                'EPG Charges (10%, min 2 AED)' => number_format($this['details']['epg_charge'], 2) . ' AED',
                'Subtotal 4' => number_format($this['subtotals']['before_vat'], 2) . ' AED',
                'VAT (5%)' => number_format($this['details']['vat'], 2) . ' AED',
                'Final Price' => number_format($this['total'], 2) . ' AED',
            ]
        ];
    }
}
