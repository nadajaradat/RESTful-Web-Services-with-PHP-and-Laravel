<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registraion extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'meeting_id'];

        /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the meeting that the registration is for.
     */
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
