<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\MaintenanceTicket;
use App\Models\PropertyChild;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->role->dash_id == 1) {
            return view('pages.dashboard.admin');
        } else {
            $propertyChildren = PropertyChild::with(['property', 'department', 'designation', 'condition', 'status'])
                ->where('is_active', 1)
                ->get();

            $totalItems = $propertyChildren->count();
            $itemsInStock = $propertyChildren->filter(function ($item) {
                return is_null($item->inventory_date) && $item->condi_id == 1;
            })->count();
            $itemsAssigned = $propertyChildren->filter(function ($item) {
                return !is_null($item->inventory_date);
            })->count();
            $lowStockConsumables = $propertyChildren->filter(function ($item) {
                return $item->property->is_consumable && $item->property->quantity < 5;
            })->count();

            $totalRepairTickets = MaintenanceTicket::where('prog_id', 1)->count();

            $totalBorrowRequests = Borrowing::where('prog_id', 1)->count();

            $releaseBorrow = Borrowing::where('prog_id', 2)->get();
            $progressRepair = MaintenanceTicket::where('prog_id', 4)->get();


            return view('pages.dashboard.default', compact(
                'totalItems', 'itemsInStock', 'itemsAssigned', 'lowStockConsumables','totalRepairTickets', 'totalBorrowRequests', 'releaseBorrow', 'progressRepair'
            ));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
