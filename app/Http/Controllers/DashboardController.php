<?php

namespace App\Http\Controllers;

use App\Models\PropertyChild;
use App\Models\PropertyParent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role->dash_id == 1) {
            $propertyParents = PropertyParent::with('category', 'brand')
                ->orderBy('purchase_price', 'desc')
                ->take(5)
                ->get();

            $todayTotal = $propertyParents->sum(function ($property) {
                return $property->purchase_price * $property->quantity;
            });

            $currentMonthStart = Carbon::now()->startOfMonth();
            $currentMonthEnd = Carbon::now()->endOfMonth();
            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

            $currentMonthTotal = DB::table('property_children')
                ->join('property_parents', 'property_children.prop_id', '=', 'property_parents.id')
                ->whereBetween('property_children.acq_date', [$currentMonthStart, $currentMonthEnd])
                ->selectRaw('SUM(property_parents.purchase_price * property_parents.quantity) as total')
                ->value('total');

            $lastMonthTotal = DB::table('property_children')
                ->join('property_parents', 'property_children.prop_id', '=', 'property_parents.id')
                ->whereBetween('property_children.acq_date', [$lastMonthStart, $lastMonthEnd])
                ->selectRaw('SUM(property_parents.purchase_price * property_parents.quantity) as total')
                ->value('total');

            $percentageChange = 0;
            if ($lastMonthTotal > 0) {
                $percentageChange = (($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100;
            }

            $currentDate = Carbon::now();
            $currentMonth = $currentDate->month;
            $currentYear = $currentDate->year;
            $daysInMonth = $currentDate->daysInMonth;

            $nonConsumableTotals = array_fill(1, $daysInMonth, 0);
            $consumableTotals = array_fill(1, $daysInMonth, 0);

            $totals = PropertyChild::select(
                DB::raw('DAY(acq_date) as day'),
                DB::raw('SUM(purchase_price * IF(is_consumable = 1, property_parents.quantity, 1)) as total_price'),  // Multiply by quantity for consumables
                'is_consumable'
            )
                ->join('property_parents', 'property_children.prop_id', '=', 'property_parents.id')
                ->whereMonth('acq_date', $currentMonth)
                ->whereYear('acq_date', $currentYear)
                ->where('type_id', 1)
                ->groupBy(DB::raw('DAY(acq_date)'), 'is_consumable')
                ->get();

            foreach ($totals as $total) {
                $day = $total->day;
                if ($total->is_consumable) {
                    $consumableTotals[$day] = $total->total_price;
                } else {
                    $nonConsumableTotals[$day] = $total->total_price;
                }
            }

            $currentMonthLabels = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentMonthLabels[] = $currentDate->format('M') . ' ' . $day;
            }

            $updatingChartDatasets = [
                [array_values($nonConsumableTotals), array_values($consumableTotals)],
            ];

            $lowStockConsumables = PropertyParent::where('is_consumable', 1)
                ->where('quantity', '<', 5)
                ->orderBy('quantity')
                ->take(10)
                ->get();

            return view('pages.dashboard.admin', compact(
                'propertyParents',
                'percentageChange',
                'updatingChartDatasets',
                'currentMonthLabels',
                'lowStockConsumables'
            ));
        } else {
            return view('pages.dashboard.default');
        }
    }
}
