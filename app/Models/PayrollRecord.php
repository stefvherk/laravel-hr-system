<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pay_period',
        'base_salary',
        'bonus',
        'deductions',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function netSalary(): float
    {
        return round(
            $this->base_salary
            + $this->bonus
            - $this->deductions,
            2
        );
    }
}
