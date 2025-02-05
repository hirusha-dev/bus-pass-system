@extends('layouts.layout')

@section('title', 'View Pass')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/viewPass.css') }}">
@endpush

@section('content')
    <!-- Main Content -->
    @if (!$pass)
        <div class="container">
            <!-- No Pass Found View -->
            <div class="no-pass-container">
                <h1>No Bus Pass Found</h1>
                <p>You have not generated a bus pass yet.</p>
                <a href="/#generate" class="btn btn-primary">Generate Bus Pass</a>
            </div>
        </div>
    @else
        <div class="container">

            <h1>View Your Bus Pass</h1>

            <div class="pass-info">
                <h2>Bus Pass Information</h2>
                <p><strong>Name:</strong> {{ $pass->full_name }}</p>
                <p><strong>NIC Number:</strong> {{ $pass->nic }}</p>
                <p><strong>Contact Number:</strong> {{ $pass->contact_number }}</p>
                <p><strong>Email:</strong> {{ $pass->email }}</p>
                <p><strong>Start Location:</strong> {{ $pass->start_location }}</p>
                <p><strong>End Location:</strong> {{ $pass->end_location }}</p>
                <p><strong>Distance:</strong> {{ $pass->distance }} km</p>
                <p><strong>Pass Type:</strong> {{ ucfirst($pass->pass_type) }}</p>
                <p><strong>Amount:</strong> Rs. {{ number_format($pass->amount, 2) }}</p>
                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($pass->start_date)->format('F Y') }}</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($pass->end_date)->format('F Y') }}</p>
                {{-- <p><strong>Status:</strong> {{ $pass->status }}</p> --}}

                {{-- <strong>Pass:</strong> --}}
                {{-- <span
                    style="color: {{ $pass->status == 'pending' ? 'orange' : ($pass->status == 'accepted' ? 'green' : 'red') }}">
                    {{ ucfirst($pass->status) }}
                </span> --}}
                <br>
                <p><strong>Pass Status:</strong> <span
                        style="color: {{ $pass->status == 'pending' ? 'orange' : ($pass->status == 'accepted' ? 'green' : 'red') }}">
                        {{ ucfirst($pass->status) }}
                    </span></p>
                <p><strong>Payment Status: @if ($pass->payment)
                            <span
                                style="color: {{ $pass->payment->status == 'paid' ? 'green' : ($pass->payment->status == 'pending' ? 'orange' : 'red') }}">
                                {{ ucfirst($pass->payment->status) }}
                            </span>
                        @else
                            <span style="color: gray;">No Payment</span>
                        @endif
                </p>

                {{-- <strong>Payment:</strong>
                @if ($pass->payment)
                    <span
                        style="color: {{ $pass->payment->status == 'paid' ? 'green' : ($pass->payment->status == 'pending' ? 'orange' : 'red') }}">
                        {{ ucfirst($pass->payment->status) }}
                    </span>
                @else
                    <span style="color: gray;">No Payment</span>
                @endif --}}
            </div>

            <!-- Calendar Section -->
            <div class="calendar-container">
                <h2>Calendar for {{ \Carbon\Carbon::parse($pass->start_date)->format('F Y') }}</h2>
                <table class="calendar">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $year = \Carbon\Carbon::parse($pass->start_date)->year;
                            $month = \Carbon\Carbon::parse($pass->start_date)->month;
                            $firstDay = \Carbon\Carbon::create($year, $month, 1);
                            $daysInMonth = $firstDay->daysInMonth;
                            $startDayOfWeek = $firstDay->dayOfWeek;
                        @endphp

                        <tr>
                            @for ($i = 0; $i < $startDayOfWeek; $i++)
                                <td></td>
                            @endfor

                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <td>{{ $day }}</td>
                                @php
                                    $startDayOfWeek++;
                                    if ($startDayOfWeek % 7 == 0) {
                                        echo '</tr><tr>';
                                    }
                                @endphp
                            @endfor

                            @while ($startDayOfWeek % 7 != 0)
                                <td></td>
                                @php $startDayOfWeek++; @endphp
                            @endwhile
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                @if ($pass->status === 'pending')
                    <a href="{{ route('editPass', $pass->id) }}">
                        <button>Edit</button>
                    </a>
                    <button disabled>Renew</button>
                    <button onclick="openPaymentModal()">Payment</button>
                    <button disabled>Download QR Code</button>
                @elseif ($pass->status === 'rejected')
                    <a href="{{ route('editPass', $pass->id) }}">
                        <button>Edit</button>
                    </a>
                    <a href="{{ route('renewPass', $pass->id) }}">
                        <button>Renew</button>
                    </a>
                    <button disabled>Payment</button>
                    <button disabled>Download QR Code</button>
                @elseif ($pass->status === 'accepted')
                    <button disabled>Edit</button>
                    <a href="{{ route('renewPass', $pass->id) }}">
                        <button>Renew</button>
                    </a>
                    <button disabled>Payment</button>
                    <button class="qr-btn" onclick="downloadQR()">Download QR Code</button>
                @else
                    <button disabled>Edit</button>
                    <button disabled>Renew</button>
                    <button disabled>Payment</button>
                    <button disabled>Download QR Code</button>
                @endif

            </div>

            <!-- QR Code Section -->
            @if ($pass->status === 'accepted')
                <div class="qr-container">
                    <h2>Download QR Code</h2>
                    <img src="{{ asset('storage/qrcodes/pass_' . $pass->id . '.svg') }}" alt="QR Code">
                </div>
            @endif

        </div>

        <!-- Payment Modal -->
        <div id="paymentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePaymentModal()">&times;</span>
                <h2>Payment Details</h2>
                <form id="paymentForm" class="payment-form" action="{{ route('processPayment', $pass->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="amount">Amount</label>
                    <input type="text" id="amount" name="amount" value="Rs. {{ number_format($pass->amount, 2) }}"
                        readonly>

                    <label for="payment_method">Payment Method</label>
                    <select id="payment_method" name="payment_method" required onchange="togglePaymentSlip()">
                        <option value="">Select Payment Method</option>
                        <option value="credit_card">Credit/Debit Card</option>
                        <option value="cash">Cash</option>
                        <option value="online">Online Transfer</option>
                    </select>

                    <label for="payment_slip">Upload Payment Slip</label>
                    <input type="file" id="payment_slip" name="payment_slip" accept="image/*">
                    <p class="condition">SVG, PNG, JPG or GIF (MAX.
                        2mb).</p>
                    <button type="submit">Pay Now</button>
                </form>
            </div>
        </div>
        <script>
            // Open Payment Modal
            function openPaymentModal() {
                document.getElementById("paymentModal").style.display = "block";
            }

            // Close Payment Modal
            function closePaymentModal() {
                document.getElementById("paymentModal").style.display = "none";
            }

            // Download QR Code
            function downloadQR() {
                var link = document.createElement('a');
                link.href = "{{ asset('storage/qrcodes/pass_' . $pass->id . '.svg') }}";
                link.download = "Bus_Pass_QR_Code.svg";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            // Close modal if user clicks outside
            window.onclick = function(event) {
                if (event.target == document.getElementById("paymentModal")) {
                    closePaymentModal();
                }
            }
        </script>
    @endif

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Bus Pass Management</p>
    </footer>



@endsection
