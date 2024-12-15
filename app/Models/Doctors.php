<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Define the table if it's not the plural of the model name
    protected $table = 'doctors';  // if your table name is 'doctors'

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'specialty',
        'status',
    ];

    // You can also define relationships here if necessary, for example, if a doctor has many appointments:
    // public function appointments()
    // {
    //     return $this->hasMany(Appointment::class);
    // }
}
