<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class Audit extends Model
{
    protected $table = 'audits';

    protected $fillable = [
        'name',
        'description',
        'subject_type',
        'subject_id',
        'event_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    protected array $auditDetails = [];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    public function logName(string $name): static
    {
        $this->auditDetails['name'] = $name;
        return $this;
    }

    public function logDesc(string $description): static
    {
        $this->auditDetails['description'] = $description;
        return $this;
    }

    public function performedOn($subject): static
    {
        $this->auditDetails['subject_type'] = get_class($subject);
        $this->auditDetails['subject_id'] = $subject->id;
        return $this;
    }

    public function logEvent(int $eventId): static
    {
        $this->auditDetails['event_id'] = $eventId;
        return $this;
    }


    public function logProperties(array $properties): static
    {
        $this->auditDetails['properties'] = json_encode($properties);
        return $this;
    }

    public function log(): static
    {
        $userId = Auth::id() ?? 1;
        $user = User::find($userId);

        $this->auditDetails['causer_type'] = $user ? get_class($user) : User::class;
        $this->auditDetails['causer_id'] = $user ? $user->id : 1;

        $this->create($this->auditDetails);

        return $this;
    }
}
