@extends('layouts.layout')

@section('title', 'Home Page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

    <div class="container">
        <h2>Pass Management</h2>
        <div class="table-responsive">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>NIC</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Start Location</th>
                        <th>End Location</th>
                        <th>Distance (km)</th>
                        <th>Province</th>
                        <th>District</th>
                        <th>Pass Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Amount (LKR)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($passes as $pass)
                        <tr>
                            <td>{{ $pass->id }}</td>
                            <td>{{ $pass->full_name }}</td>
                            <td>{{ $pass->nic }}</td>
                            <td>{{ $pass->contact_number }}</td>
                            <td>{{ $pass->email }}</td>
                            <td>{{ $pass->start_location }}</td>
                            <td>{{ $pass->end_location }}</td>
                            <td>{{ $pass->distance }}</td>
                            <td>{{ $pass->province }}</td>
                            <td>{{ $pass->district }}</td>
                            <td>{{ ucfirst($pass->pass_type) }}</td>
                            <td>{{ \Carbon\Carbon::parse($pass->start_date)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pass->end_date)->format('d F Y') }}</td>
                            <td>Rs. {{ number_format($pass->amount, 2) }}</td>
                            <!-- Status Column -->
                            <td>
                                <strong>Pass:</strong>
                                <span
                                    style="color: {{ $pass->status == 'pending' ? 'orange' : ($pass->status == 'accepted' ? 'green' : 'red') }}">
                                    {{ ucfirst($pass->status) }}
                                </span>
                                <br>

                                <strong>Payment:</strong>
                                @if ($pass->payment)
                                    <span
                                        style="color: {{ $pass->payment->status == 'paid' ? 'green' : ($pass->payment->status == 'pending' ? 'orange' : 'red') }}">
                                        {{ ucfirst($pass->payment->status) }}
                                    </span>
                                @else
                                    <span style="color: gray;">No Payment</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if ($pass->status == 'pending')
                                    <a href="{{ route('admin.pass-approve', $pass->id) }}"
                                        class="btn btn-success">Approve</a>
                                    <a href="{{ route('admin.pass-reject', $pass->id) }}" class="btn btn-danger">Reject</a>
                                @elseif($pass->status == 'accepted')
                                    @if ($pass->qr_code)
                                        <img src="{{ asset('storage/qrcodes/pass_' . $pass->id . '.svg') }}" alt="QR Code"
                                            width="100"><br>

                                        <a href="{{ asset('storage/' . $pass->qr_code) }}" download
                                            class="btn btn-primary">Download QR</a>
                                    @endif
                                @endif
                                <!-- View Payment Button -->
                                <button class="btn btn-info" onclick="showPaymentModal({{ $pass->id }})">View
                                    Payment</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePaymentModal()">&times;</span>
            <h2>Payment Details</h2>
            <p><strong>Payment Method:</strong> <span id="payment_method"></span></p>
            <p><strong>Amount Paid:</strong> Rs. <span id="payment_amount"></span></p>
            <p><strong>Payment Date:</strong> <span id="payment_date"></span></p>
            <p><strong>Status:</strong> <span id="payment_status"></span></p>
            <div id="payment_slip_container" style="display: none;">
                <h3>Payment Slip:</h3>
                <img id="payment_slip" src="" alt="Payment Slip" width="200">
            </div>
        </div>
    </div>

    <script>
        function showPaymentModal(passId) {
            fetch(`/admin/get-payment/${passId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        document.getElementById("payment_method").innerText = data.payment_method;
                        document.getElementById("payment_amount").innerText = data.amount;
                        document.getElementById("payment_date").innerText = data.payment_date;
                        document.getElementById("payment_status").innerText = data.status;

                        if (data.payment_slip) {
                            document.getElementById("payment_slip").src = `${data.payment_slip}`;
                            document.getElementById("payment_slip_container").style.display = "block";
                        } else {
                            document.getElementById("payment_slip_container").style.display = "none";
                        }

                        document.getElementById("paymentModal").style.display = "block";
                    }
                });
        }

        function closePaymentModal() {
            document.getElementById("paymentModal").style.display = "none";
        }
    </script>

@endsection
