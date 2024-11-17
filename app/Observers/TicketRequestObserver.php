<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Ticket;

class TicketRequestObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        (new Audit())
            ->logName('Add Ticket Request')
            ->logDesc("A new ticket request: '{$ticket->ticket_num}' has been created.")
            ->performedOn($ticket)
            ->logEvent(1)
            ->logProperties([
                'ticket number' => $ticket->ticket_num,
                'name' => $ticket->name,
                'status' => 'Pending',
            ])
            ->log();
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        if ($ticket->isDirty()) {
            $changes = [
                'old' => [],
                'new' => []
            ];

            foreach ($ticket->getDirty() as $attribute => $newValue) {
                if ($attribute === 'is_active' || $attribute === 'updated_at') {
                    continue;
                }

                $oldValue = $ticket->getOriginal($attribute);

                $changes['old'][$attribute] = $oldValue;
                $changes['new'][$attribute] = $newValue;
            }

            if (!$ticket->isDirty('prog_id')) {
                (new Audit())
                    ->logName('Edit Ticket Request')
                    ->logDesc("The ticket request: '{$ticket->ticket_num}' has been updated.")
                    ->performedOn($ticket)
                    ->logEvent(2)
                    ->logProperties($changes)
                    ->log();
            } else {
                (new Audit())
                    ->logName('Approved Ticket Request')
                    ->logDesc("The ticket request: '{$ticket->ticket_num}'  have been approved.")
                    ->performedOn($ticket)
                    ->logEvent(2)
                    ->logProperties([
                        'ticket number' => $ticket->ticket_num,
                        'name' => $ticket->name,
                        'status' => 'Approved',
                    ])
                    ->log();
            }
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleting(Ticket $ticket): void
    {
        (new Audit())
            ->logName('Delete Ticket Request')
            ->logDesc("The ticket request: '{$ticket->name}' has been permanently deleted.")
            ->performedOn($ticket)
            ->logEvent(3)
            ->logProperties([
                'ticket number' => $ticket->ticket_num,
                'name' => $ticket->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
