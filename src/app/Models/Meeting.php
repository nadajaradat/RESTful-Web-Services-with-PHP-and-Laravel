<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\Auth\RegistrationTest;

class Meeting extends Model
{
    use HasFactory;
    protected $table = 'meetings';
    protected $fillable = ['title', 'description', 'date', 'time'];

    /**
     * Get the user that created the meeting.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all registrations for the meeting.
     */
    public function registrations()
    {
        // Assuming the Registration model exists and is correctly named
        return $this->hasMany(Registraion::class);
    }
}
