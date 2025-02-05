<?php

namespace App\Http\Controllers;

use App\Models\BusPass;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function userManagement()
    {
        $users = User::all();
        return view('pages.admin.user-management', compact('users'));
    }

    public function passManagement()
    {
        $passes = BusPass::with(['user', 'payment'])->get();

        return view('pages.admin.pass-management', compact('passes'));
    }

    public function approvePass($id)
    {
        $pass = BusPass::findOrFail($id);
        $pass->status = 'accepted';
        $pass->save();

        // Update Payment Status
        $payment = $pass->payment;
        if ($payment) {
            $payment->status = 'paid';
            $payment->save();
        }

        // QR Code Data
        $qrData = json_encode([
            'Pass ID' => $pass->id,
            'User Name' => $pass->full_name,
            'NIC' => $pass->nic,
            'Start Location' => $pass->start_location,
            'End Location' => $pass->end_location,
            'Pass Type' => ucfirst($pass->pass_type),
            'Amount' => 'Rs. ' . number_format($pass->amount, 2),
            'Start Date' => $pass->start_date,
            'End Date' => $pass->end_date
        ]);

        // Generate QR Code as PNG and store it
        $qrCode = QrCode::size(300)->generate($qrData);

        // Define file path and extension
        $fileExtension = 'svg'; // Default format
        $qrCodePath = "qrcodes/pass_{$pass->id}.{$fileExtension}";

        // Store the QR Code
        Storage::disk('public')->put($qrCodePath, $qrCode);

        // Save path in database
        $pass->qr_code = $qrCodePath;
        $pass->save();



        toastr()->success('Pass Approved Successfully!');
        return redirect()->route('admin.pass-management');
    }

    public function rejectPass($id)
    {
        $pass = BusPass::findOrFail($id);
        $pass->status = 'rejected';
        $pass->save();

        // Update Payment Status
        $payment = $pass->payment;
        if ($payment) {
            $payment->status = 'failed';
            $payment->save();
        }


        toastr()->success('Pass Rejected!');
        return redirect()->route('admin.pass-management');
    }

    public function getPaymentDetails($id)
    {
        try {
            $payment = Payment::where('buss_pass_id', $id)->first();

            if (!$payment) {
                return response()->json(['error' => 'No payment found for this pass.'], 404);
            }

            return response()->json([
                'payment_method' => ucfirst(str_replace('_', ' ', $payment->payment_method)),
                'amount' => number_format($payment->amount, 2),
                'payment_date' => \Carbon\Carbon::parse($payment->payment_date)->format('d F Y, H:i A'),
                'status' => ucfirst($payment->status),
                'payment_slip' => $payment->payment_slip ? asset('storage/' . $payment->payment_slip) : null
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching payment details.'], 500);
        }
    }
}
