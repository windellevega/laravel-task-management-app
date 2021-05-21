<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'created_by_id',
        'assigned_to_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function statusHistory()
    {
        return $this->belongsToMany(Status::class)
                ->withPivot('remarks')
                ->withTimestamps()
                ->orderBy('checklist_status.created_at', 'desc');
    }
}
