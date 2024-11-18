<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\MaintenanceTicket;

class TicketRequestObserver
{
    /**
     * Handle the MaintenanceTicket "created" event.
     */
    public function created(MaintenanceTicket $maintenanceTicket): void
    {
        (new Audit())
            ->logName('Add Maintenance Ticket')
            ->logDesc("A new ticket request: '{$maintenanceTicket->ticket_num}' has been created.")
            ->performedOn($maintenanceTicket)
            ->logEvent(1)
            ->logProperties([
                'ticket number' => $maintenanceTicket->ticket_num,
                'name' => $maintenanceTicket->name,
                'status' => 'Pending',
            ])
            ->log();
    }

    /**
     * Handle the MaintenanceTicket "updated" event.
     */
    public function updated(MaintenanceTicket $maintenanceTicket): void
    {
        if ($maintenanceTicket->isDirty()) {
            $changes = [
                'old' => [],
                'new' => []
            ];

            foreach ($maintenanceTicket->getDirty() as $attribute => $newValue) {
                if ($attribute === 'is_active' || $attribute === 'updated_at') {
                    continue;
                }

                $oldValue = $maintenanceTicket->getOriginal($attribute);

                $changes['old'][$attribute] = $oldValue;
                $changes['new'][$attribute] = $newValue;
            }

            if (!$maintenanceTicket->isDirty('prog_id') && !$maintenanceTicket->isDirty('started_at') &&
                !$maintenanceTicket->isDirty('completed_at')) {
                (new Audit())
                    ->logName('Edit Maintenance Ticket')
                    ->logDesc("The ticket request: '{$maintenanceTicket->ticket_num}' has been updated.")
                    ->performedOn($maintenanceTicket)
                    ->logEvent(2)
                    ->logProperties($changes)
                    ->log();
            } else {
                if ($maintenanceTicket->prog_id == 2) {
                    (new Audit())
                        ->logName('Approved Maintenance Ticket')
                        ->logDesc("The ticket request: '{$maintenanceTicket->ticket_num}'  have been approved.")
                        ->performedOn($maintenanceTicket)
                        ->logEvent(2)
                        ->logProperties([
                            'ticket number' => $maintenanceTicket->ticket_num,
                            'name' => $maintenanceTicket->name,
                            'status' => 'Approved',
                        ])
                        ->log();
                } elseif ($maintenanceTicket->prog_id == 4) {
                    (new Audit())
                        ->logName('Start Maintenance Ticket')
                        ->logDesc("The ticket request: '{$maintenanceTicket->ticket_num}' have been started.")
                        ->performedOn($maintenanceTicket)
                        ->logEvent(2)
                        ->logProperties([
                            'ticket number' => $maintenanceTicket->ticket_num,
                            'name' => $maintenanceTicket->name,
                            'status' => 'Started',
                        ])
                        ->log();
                } elseif ($maintenanceTicket->prog_id == 5) {
                    (new Audit())
                        ->logName('Complete Maintenance Ticket')
                        ->logDesc("The ticket request: '{$maintenanceTicket->ticket_num}' has been completed.")
                        ->performedOn($maintenanceTicket)
                        ->logEvent(2)
                        ->logProperties([
                            'ticket number' => $maintenanceTicket->ticket_num,
                            'name' => $maintenanceTicket->name,
                            'status' => 'Completed',
                        ])
                        ->log();
                } elseif ($maintenanceTicket->prog_id == 1) {
                    (new Audit())
                        ->logName('Cancelled Maintenance Ticket')
                        ->logDesc("The ticket request: '{$maintenanceTicket->ticket_num}' has been cancelled.")
                        ->performedOn($maintenanceTicket)
                        ->logEvent(2)
                        ->logProperties([
                            'ticket number' => $maintenanceTicket->ticket_num,
                            'name' => $maintenanceTicket->name,
                            'status' => 'Cancelled',
                        ])
                        ->log();
                }
            }
        }
    }

    /**
     * Handle the MaintenanceTicket "deleted" event.
     */
    public function deleting(MaintenanceTicket $maintenanceTicket): void
    {
        (new Audit())
            ->logName('Delete Maintenance Ticket')
            ->logDesc("The ticket request: '{$maintenanceTicket->name}' has been permanently deleted.")
            ->performedOn($maintenanceTicket)
            ->logEvent(3)
            ->logProperties([
                'ticket number' => $maintenanceTicket->ticket_num,
                'name' => $maintenanceTicket->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
