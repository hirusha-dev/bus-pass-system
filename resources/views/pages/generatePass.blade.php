@extends('layouts.layout')

@section('title', 'Generate Pass')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/generatePass.css') }}">
@endpush

@section('content')
    <!-- Main Content -->
    <div class="container">
        <h2>{{ isset($pass) ? (isset($renewMode) ? 'Renew Your Bus Season Ticket Online' : 'Edit Your Bus Season Ticket Online') : 'Generate Your Bus Season Ticket Online' }}
        </h2>

        <form
            action="{{ isset($pass) ? (isset($renewMode) ? route('renewPass.store', $pass->id) : route('updatePass', $pass->id)) : route('generatePass.store') }}"
            method="POST">
            @csrf

            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-item">
                    <label>FULL NAME:</label>
                    <input type="text" name="full_name" placeholder="Enter your Full Name"
                        value="{{ old('full_name', $pass->full_name ?? ($user->name ?? '')) }}" required>

                    <label>NIC NUMBER:</label>
                    <input type="text" name="nic" placeholder="Enter your NIC Number"
                        value="{{ old('nic', $pass->nic ?? '') }}" required>

                    <label>CONTACT NUMBER:</label>
                    <input type="text" name="contact_number" placeholder="Enter your Contact Number"
                        value="{{ old('contact_number', $pass->contact_number ?? '') }}" required>

                    <label>EMAIL ADDRESS:</label>
                    <input type="email" name="email" placeholder="Enter your Email Address"
                        value="{{ old('email', $pass->email ?? ($user->email ?? '')) }}" required>

                    <label>START LOCATION:</label>
                    <input type="text" name="start_location" placeholder="Enter Start Location"
                        value="{{ old('start_location', isset($renewMode) ? '' : $pass->start_location ?? '') }}" required>

                    <label>END LOCATION:</label>
                    <input type="text" name="end_location" placeholder="Enter End Location"
                        value="{{ old('end_location', isset($renewMode) ? '' : $pass->end_location ?? '') }}" required>

                    <label>DISTANCE:</label>
                    <input type="number" name="distance" placeholder="Enter Distance"
                        value="{{ old('distance', isset($renewMode) ? '' : $pass->distance ?? '') }}" required>
                </div>

                <!-- Right Column -->
                <div class="form-item">
                    <label>PROVINCE:</label>
                    <select name="province" id="province" required onchange="updateDistricts()">
                        <option value="">Select Province</option>
                        <option value="Western Province"
                            {{ old('province', $pass->province ?? '') == 'Western Province' ? 'selected' : '' }}>
                            Western Province
                        </option>
                        <option value="Central Province"
                            {{ old('province', $pass->province ?? '') == 'Central Province' ? 'selected' : '' }}>
                            Central Province
                        </option>
                        <option value="Southern Province"
                            {{ old('province', $pass->province ?? '') == 'Southern Province' ? 'selected' : '' }}>
                            Southern Province
                        </option>
                        <option value="Northern Province"
                            {{ old('province', $pass->province ?? '') == 'Northern Province' ? 'selected' : '' }}>
                            Northern Province
                        </option>
                        <option value="Eastern Province"
                            {{ old('province', $pass->province ?? '') == 'Eastern Province' ? 'selected' : '' }}>
                            Eastern Province
                        </option>
                        <option value="North Western Province"
                            {{ old('province', $pass->province ?? '') == 'North Western Province' ? 'selected' : '' }}>
                            North Western Province
                        </option>
                        <option value="North Central Province"
                            {{ old('province', $pass->province ?? '') == 'North Central Province' ? 'selected' : '' }}>
                            North Central Province
                        </option>
                        <option value="Uva Province"
                            {{ old('province', $pass->province ?? '') == 'Uva Province' ? 'selected' : '' }}>
                            Uva Province
                        </option>
                        <option value="Sabaragamuwa Province"
                            {{ old('province', $pass->province ?? '') == 'Sabaragamuwa Province' ? 'selected' : '' }}>
                            Sabaragamuwa Province
                        </option>

                    </select>

                    <label>DISTRICT:</label>
                    <select name="district" id="district" required
                        data-selected="{{ old('district', $pass->district ?? '') }}">
                        <option value="">Select District</option>
                    </select>


                    <label>PASS TYPE:</label>
                    <select name="pass_type" required>
                        <option value="">Select Pass Type</option>
                        <option value="student"
                            {{ old('pass_type', $pass->pass_type ?? '') == 'student' ? 'selected' : '' }}>
                            Student
                        </option>
                        <option value="employee"
                            {{ old('pass_type', $pass->pass_type ?? '') == 'employee' ? 'selected' : '' }}>
                            Employee
                        </option>
                    </select>


                    <label>START DATE:</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $pass->start_date ?? '') }}"
                        required>

                    <label>END DATE:</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $pass->end_date ?? '') }}" required>

                    <label>AMOUNT TO PAY (LKR):</label>
                    <input type="number" name="amount" placeholder="Enter amount (LKR)"
                        value="{{ old('amount', $pass->amount ?? '') }}" required>
                </div>
            </div>

            <button type="submit">Generate Ticket</button>
        </form>

    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Bus Pass Management
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateDistricts();
        });

        function updateDistricts() {
            var province = document.getElementById("province").value;
            var districtSelect = document.getElementById("district");
            var selectedDistrict = districtSelect.getAttribute("data-selected"); // Get stored district

            var districts = {
                "Western Province": ["Colombo", "Gampaha", "Kalutara"],
                "Central Province": ["Kandy", "Matale", "Nuwara Eliya"],
                "Southern Province": ["Galle", "Matara", "Hambantota"],
                "Northern Province": ["Jaffna", "Kilinochchi", "Mannar", "Mullaitivu", "Vavuniya"],
                "Eastern Province": ["Trincomalee", "Batticaloa", "Ampara"],
                "North Western Province": ["Kurunegala", "Puttalam"],
                "North Central Province": ["Anuradhapura", "Polonnaruwa"],
                "Uva Province": ["Badulla", "Monaragala"],
                "Sabaragamuwa Province": ["Ratnapura", "Kegalle"]
            };

            // Clear existing options
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (province in districts) {
                districts[province].forEach(function(district) {
                    var option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;

                    // Set selected district if it matches
                    if (selectedDistrict === district) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                });
            }
        }

        // Ensure district updates when province changes
        document.getElementById("province").addEventListener("change", updateDistricts);
    </script>
@endsection
