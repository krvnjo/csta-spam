<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Event;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Throwable;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audits = Audit::with([
            'event' => function ($query) {
                $query->with(['badge', 'legend']);
            },
            'subject',
            'causer.role'
        ])->orderBy('name')->get();
        $types = Type::get();
        $events = Event::with('badge', 'legend')->get();
        $users = User::with('role')->where('role_id', '!=', 1)->orderBy('lname')->get();

        return view('pages.other.audit-history',
            compact(
                'audits',
                'types',
                'events',
                'users',
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $audit = Audit::findOrFail(Crypt::decryptString($request->input('id')));

            $createdBy = Audit::where('subject_type', Audit::class)->where('subject_id', $audit->id)->where('event_id', 1)->first();
            $createdDetails = $this->getUserAuditDetails($createdBy);

            return response()->json([
                'success' => true,
                'audit' => $audit->name,
                'description' => $audit->description,
                'event_name' => $audit->event->name,
                'event_badge' => $audit->event->badge->class,
                'event_legend' => $audit->event->legend->class,
                'properties' => json_decode($audit->properties),
                'created_img' => $createdDetails['image'],
                'created_by' => $createdDetails['name'],
                'created_at' => $audit->created_at->format('D, M d, Y | h:i A'),
            ]);
        } catch (Throwable $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'title' => 'Oops! Something went wrong.',
                'message' => 'An error occurred while fetching the audit record. Please try again later.',
            ], 500);
        }
    }
}
