<?php

namespace App\Services;

class ShippingCalculatorService
{
    private const PACKAGING_COST = 5.25;
    private const FUEL_RATE = 0.02;
    private const EPG_RATE = 0.10;
    private const VAT_RATE = 0.05;
    private const EXTRA_WEIGHT_BASE = 5;
    private const EXTRA_COST_PER_KG = 2;

    public function calculate(array $data): array
    {
        $destination = $data['destination_type'];

        $base = $this->getBaseCost($data['monthly_shipments'], $destination);
        $finalWeight = $this->getFinalWeight($data['weight'], $data['length'], $data['width'], $data['height']);

        $extraWeight = max(0, $finalWeight - self::EXTRA_WEIGHT_BASE);
        $extraCost = ceil($extraWeight) * self::EXTRA_COST_PER_KG;

        $costBeforeFuel = $base + $extraCost;
        $fuel = $this->getFuelSurcharge($costBeforeFuel);

        $costBeforePackaging = $costBeforeFuel + $fuel;
        $packaging = self::PACKAGING_COST;

        $costBeforeEPG = $costBeforePackaging + $packaging;
        $epg = $this->getEPGCharge($costBeforeEPG);

        $costBeforeVAT = $costBeforeEPG + $epg;
        $vat = $this->getVAT($costBeforeVAT);

        $total = round($costBeforeVAT + $vat, 2);

        return [
            'total' => $total,
            'used_weight' => round($finalWeight, 2),
            'extra_weight' => round($extraWeight, 2),
            'destination_type' => $destination,
            'details' => [
                'base_cost' => $base,
                'extra_cost' => $extraCost,
                'fuel_surcharge' => $fuel,
                'packaging_cost' => $packaging,
                'epg_charge' => $epg,
                'vat' => $vat,
            ],
            'subtotals' => [
                'before_fuel' => round($costBeforeFuel, 2),
                'before_packaging' => round($costBeforePackaging, 2),
                'before_epg' => round($costBeforeEPG, 2),
                'before_vat' => round($costBeforeVAT, 2),
            ],
        ];
    }

    private function getBaseCost(int $monthly, string $destination): int
    {
        return match (true) {
            $monthly <= 250 => $destination === 'normal' ? 14 : 49,
            $monthly <= 500 => $destination === 'normal' ? 12 : 47,
            default => $destination === 'normal' ? 11 : 46,
        };
    }

    private function getFinalWeight(float $actual, float $length, float $width, float $height): float
    {
        $volumetric = ($length * $width * $height) / 5000;
        return max($actual, $volumetric);
    }

    private function getFuelSurcharge(float $subtotal): float
    {
        return round($subtotal * self::FUEL_RATE, 2);
    }

    private function getEPGCharge(float $subtotal): float
    {
        return max(2, round($subtotal * self::EPG_RATE, 2));
    }

    private function getVAT(float $subtotal): float
    {
        return round($subtotal * self::VAT_RATE, 2);
    }
}
