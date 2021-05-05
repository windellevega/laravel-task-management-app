<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
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
        'user_id',
        'assigned_to_id',
    ];

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
