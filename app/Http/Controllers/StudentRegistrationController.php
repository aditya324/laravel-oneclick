<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\StudentRegistration;

use App\Models\Payment;


class StudentRegistrationController extends Controller
{
    //

    public function store(Request $request)
    {


        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:15',
            'email'      => 'required|email|unique:student_registrations,email',
            'college_id' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $path = $request->file('college_id')
            ->store('college-ids', 'public');


        $student = StudentRegistration::create([
            'name'       => $validated['name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'],
            'college_id_path' => $path,
        ]);

        return redirect()->route('quiz.start', $student->id);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
