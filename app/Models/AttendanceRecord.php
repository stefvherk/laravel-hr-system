<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AttendanceRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'check_in_at',
        'check_out_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function workedHours(): ?float
    {
        if (! $this->check_out_at) {
            return null;
        }

        $checkIn = Carbon::parse($this->check_in_at);
        $checkOut = Carbon::parse($this->check_out_at);

        return round($checkIn->diffInMinutes($checkOut, false) / 60, 2);
    }
}
