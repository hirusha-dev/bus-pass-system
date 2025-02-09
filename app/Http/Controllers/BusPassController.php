<?php

namespace App\Http\Controllers;

use App\Models\BusPass;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BusPassController extends Controller
{
    public function store(Request $request)
    {
        // Check if the user already has an active pass (pending or accepted)
        $existingPass = BusPass::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existingPass) {
            toastr()->error('You already have an active pass.');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'nic' => 'required|string|unique:bus_passes,nic',
            'contact_number' => 'required|string',
            'email' => 'required|email|unique:bus_passes,email',
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'distance' => 'required|integer',
            'province' => 'required|string',
            'district' => 'required|string',
            'pass_type' => 'required|in:student,employee',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            // Get all validation error messages as a string
            $errors = implode('<br>', $validator->errors()->all());

            // Pass the error messages to toastr
            toastr()->error($errors);

            // Redirect back with input and errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        BusPass::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'nic' => $request->nic,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'distance' => $request->distance,
            'province' => $request->province,
            'district' => $request->district,
            'pass_type' => $request->pass_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        toastr()->success('Ticket Generated Successfully!');

        return redirect()->route('viewPass');
    }

    public function edit($id)
    {
        $pass = BusPass::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('pages.generatePass', compact('pass'));
    }

    public function processPayment(Request $request, $id)
    {
        $pass = BusPass::findOrFail($id);

        // Check if a payment already exists for this pass
        $existingPayment = Payment::where('buss_pass_id', $pass->id)
            ->where('status', '!=', 'failed') // Only allow resubmission if previous payment failed
            ->first();

        if ($existingPayment) {
            toastr()->error('You have already submitted a payment for this pass.');
            return redirect()->back();
        }
        // Validate Payment Data
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:credit_card,cash,online',
            'payment_slip' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            // Get all validation error messages as a string
            $errors = implode('<br>', $validator->errors()->all());

            // Pass the error messages to toastr
            toastr()->error($errors);

            // Redirect back with input and errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle Payment Slip Upload
        $paymentSlipPath = null;
        if ($request->hasFile('payment_slip')) {
            $paymentSlipPath = $request->file('payment_slip')->store('payment_slips', 'public');
        }

        // Create Payment Record
        Payment::create([
            'buss_pass_id' => $pass->id,
            'payment_method' => $request->payment_method,
            'amount' => $pass->amount,
            'payment_date' => Carbon::now(),
            'status' => 'pending',
            'payment_slip' => $paymentSlipPath,
        ]);

        toastr()->success('Payment successful!');
        return redirect()->route('viewPass');
    }

    public function update(Request $request, $id)
    {
        $pass = BusPass::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $this->validatePass($request, $pass->id);

        $pass->update($this->passData($request));

        // Delete existing payment if any
        if ($pass->payment) {
            $pass->payment->delete();
        }

        toastr()->success('Bus pass updated successfully!');

        return redirect()->route('viewPass');
    }

    public function renew($id)
    {
        $pass = BusPass::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $renewMode = 'renewMode';
        return view('pages.generatePass', compact('pass', 'renewMode')); // Indicating it's a renewal process
    }

    private function validatePass(Request $request, $passId = null)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'nic' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email|unique:bus_passes,email,' . $passId,
            'start_location' => 'required|string',
            'end_location' => 'required|string',
            'distance' => 'required|integer',
            'province' => 'required|string',
            'district' => 'required|string',
            'pass_type' => 'required|in:student,employee',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'required|numeric|min:0',
        ];

        Validator::make($request->all(), $rules)->validate();
    }

    private function passData(Request $request)
    {
        return [
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'nic' => $request->nic,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'distance' => $request->distance,
            'province' => $request->province,
            'district' => $request->district,
            'pass_type' => $request->pass_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'amount' => $request->amount,
            'status' => 'pending',
        ];
    }
}
