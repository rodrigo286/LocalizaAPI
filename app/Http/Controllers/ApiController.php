<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function vehicles(Request $request): JsonResponse
    {
        $vehicles = [
            ['id' => 'VH-1001', 'model' => 'Chevrolet Onix', 'category' => 'Hatch', 'daily_price' => 139.90, 'transmission' => 'automatic', 'fuel' => 'flex'],
            ['id' => 'VH-1002', 'model' => 'Jeep Renegade', 'category' => 'SUV', 'daily_price' => 239.90, 'transmission' => 'automatic', 'fuel' => 'flex'],
            ['id' => 'VH-1003', 'model' => 'BYD Dolphin', 'category' => 'Electric', 'daily_price' => 269.90, 'transmission' => 'automatic', 'fuel' => 'electric'],
        ];

        return $this->paginated($request, $vehicles);
    }

    public function createReservation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer.name' => ['required', 'string'],
            'customer.document' => ['required', 'string'],
            'pickup_agency_id' => ['required', 'string'],
            'return_agency_id' => ['required', 'string'],
            'pickup_at' => ['required', 'date'],
            'return_at' => ['required', 'date', 'after:pickup_at'],
            'vehicle_category' => ['required', 'string'],
            'insurances' => ['nullable', 'array'],
        ]);

        return response()->json([
            'id' => 'RSV-'.random_int(10000, 99999),
            'status' => 'confirmed',
            'total' => 684.90,
            'currency' => 'BRL',
            'request' => $data,
        ], 201);
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $data = $request->validate([
            'reservation_id' => ['required', 'string'],
            'coupon' => ['required', 'string'],
        ]);

        return response()->json([
            'reservation_id' => $data['reservation_id'],
            'coupon' => $data['coupon'],
            'discount_percent' => 10,
            'status' => 'applied',
        ]);
    }

    public function telemetry(string $vehicle): JsonResponse
    {
        return response()->json([
            'vehicle_id' => $vehicle,
            'gps' => ['lat' => -19.9191, 'lng' => -43.9386],
            'odometer_km' => 42871,
            'fuel_percent' => 67,
            'speed_kmh' => 42,
            'status' => 'moving',
            'recorded_at' => now()->toIso8601String(),
        ]);
    }

    public function linkDriver(Request $request, string $vehicle): JsonResponse
    {
        $data = $request->validate(['driver_id' => ['required', 'string']]);

        return response()->json([
            'vehicle_id' => $vehicle,
            'driver_id' => $data['driver_id'],
            'status' => 'linked',
        ]);
    }

    public function createGeofence(Request $request, string $vehicle): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'center.lat' => ['required', 'numeric', 'between:-90,90'],
            'center.lng' => ['required', 'numeric', 'between:-180,180'],
            'radius_m' => ['required', 'integer', 'min:50'],
        ]);

        return response()->json([
            'id' => 'GEO-'.random_int(1000, 9999),
            'vehicle_id' => $vehicle,
            ...$data,
        ], 201);
    }

    public function createClaim(Request $request): JsonResponse
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'string'],
            'driver_id' => ['required', 'string'],
            'description' => ['required', 'string'],
            'photos' => ['nullable', 'array'],
            'police_report_url' => ['nullable', 'url'],
        ]);

        return response()->json([
            'id' => 'CLM-'.random_int(1000, 9999),
            'status' => 'opened',
            'request' => $data,
        ], 201);
    }

    public function scheduleMaintenance(Request $request): JsonResponse
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'string'],
            'scheduled_at' => ['required', 'date'],
            'service_type' => ['required', 'string'],
        ]);

        return response()->json([
            'id' => 'MNT-'.random_int(1000, 9999),
            'status' => 'scheduled',
            'request' => $data,
        ], 201);
    }

    public function maintenanceHistory(Request $request, string $vehicle): JsonResponse
    {
        return $this->paginated($request, [
            ['vehicle_id' => $vehicle, 'date' => '2026-08-10', 'service' => 'oil_and_filters', 'odometer_km' => 40000, 'dashboard_alerts' => []],
            ['vehicle_id' => $vehicle, 'date' => '2026-05-02', 'service' => 'brakes', 'odometer_km' => 35000, 'dashboard_alerts' => ['tire_pressure']],
        ]);
    }

    public function billingStatements(Request $request): JsonResponse
    {
        $customerId = (string) $request->query('customer_id', 'C-001');

        return $this->paginated($request, [
            ['invoice_id' => 'INV-901', 'customer_id' => $customerId, 'amount' => 1840.50, 'status' => 'paid', 'due_date' => '2026-10-10'],
            ['invoice_id' => 'INV-902', 'customer_id' => $customerId, 'amount' => 720.00, 'status' => 'open', 'due_date' => '2026-11-10'],
        ]);
    }

    public function trafficFines(Request $request): JsonResponse
    {
        return $this->paginated($request, [
            [
                'id' => 'FINE-101',
                'vehicle_id' => (string) $request->query('vehicle_id', 'VH-1001'),
                'driver_id' => (string) $request->query('driver_id', 'DRV-77'),
                'amount' => 195.23,
                'status' => 'pending',
                'occurred_at' => '2026-09-21',
            ],
        ]);
    }

    private function paginated(Request $request, array $data): JsonResponse
    {
        $page = max(1, (int) $request->query('page', 1));
        $perPage = max(1, min(100, (int) $request->query('per_page', 10)));

        return response()->json([
            'data' => array_values(array_slice($data, ($page - 1) * $perPage, $perPage)),
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => count($data),
            ],
        ]);
    }
}
