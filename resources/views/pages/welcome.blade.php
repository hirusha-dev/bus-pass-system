@extends('layouts.layout')

@section('title', 'Homepage')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <div class="slideshow-container">
        <img class="slideshow-image active" src="{{ asset('images/image 03.png') }}">
        <img class="slideshow-image" src="{{ asset('images/image 02.jpg') }}">
        <img class="slideshow-image" src="{{ asset('images/image 01.jpg') }}">
    </div>

    <section id="home">
        <h2>Welcome to the Bus Pass Management System</h2>

        <p> Welcome to our Smart Bus Pass Management System, designed to make your daily commute more efficient and
            hassle-free.
            Our innovative platform allows you to easily manage and track your bus pass, ensuring smooth and convenient
            access
            to public transportation. With features like online pass renewal, real-time balance tracking, and instant
            updates on
            route changes, you'll never miss a ride. Whether you're a student, regular commuter, or occasional traveler, our
            system offers a range of customizable pass options to fit your needs. Enjoy a smarter, more organized travel
            experience with our Smart Bus Pass Management System...!
            <br> Manage your bus pass easily.
        </p>
    </section>

    <section id="generate">
        <h2>Generate Bus Pass</h2>
        Fill in the details to generate your bus pass <br>
        <a href="/generate-pass">GENERATE PASS</a>

        <!-- Price Table Section -->
        <h3>Bus Pass Pricing Based on Distance</h3>
        <table>
            <thead>
                <tr>
                    <th>Distance (km)</th>
                    <th>Pass Type</th>
                    <th>Price (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>0 - 10 km</td>
                    <td>Student</td>
                    <td>Rs. 500</td>
                </tr>
                <tr>
                    <td>10 - 20 km</td>
                    <td>Student</td>
                    <td>Rs. 800</td>
                </tr>
                <tr>
                    <td>0 - 10 km</td>
                    <td>Regular</td>
                    <td>Rs. 700</td>
                </tr>
                <tr>
                    <td>10 - 20 km</td>
                    <td>Regular</td>
                    <td>Rs. 1,200</td>
                </tr>
                <tr>
                    <td>20 - 40 km</td>
                    <td>Regular</td>
                    <td>Rs. 1,800</td>
                </tr>
                <tr>
                    <td>40+ km</td>
                    <td>Regular</td>
                    <td>Rs. 2,500</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section id="view-pass">
        <h2>View Pass Details</h2>
        Check your bus pass details here. <br>
        <a href="view-pass">VIEW PASS</a>
    </section>

    <!-- Updated Contact Us Section with Details -->
    <section id="contact">
        <h2>Contact Us</h2>

        <!-- Contact Details -->
        <div id="contact-details">
            <h3>Our Contact Information:</h3>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i><strong>Sri Lanka Central Transport Board,<br> Bernard Soysa
                        Mawatha,<br> Colombo 00500</strong></li>
                <li><i class="fas fa-phone-alt"></i><strong> 0112 581 120</strong></li>
                <li><i class="fas fa-envelope"></i><strong>info@sltb.lk</strong></li>
            </ul>

            <!-- Google Map -->
            <h3>Our Location:</h3>
            <p><iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1791.3992264102073!2d79.87303355278911!3d6.893757560847473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25a2cb615a5ed%3A0x9d90a07be0b1c86e!2sSri%20Lanka%20Transport%20Board%20(S.L.T.B.)%20Head%20Office!5e0!3m2!1sen!2slk!4v1734761484536!5m2!1sen!2slk"
                    width="1430" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></p>
        </div>
    </section>

    <footer>
        &copy; 2024 Bus Pass Management
    </footer>

    <script>
        const slideshowImages = document.querySelectorAll('.slideshow-image');
        let currentImageIndex = 0;

        function showNextImage() {
            slideshowImages[currentImageIndex].classList.remove('active');
            currentImageIndex = (currentImageIndex + 1) % slideshowImages.length;
            slideshowImages[currentImageIndex].classList.add('active');
        }

        setInterval(showNextImage, 3000); // Change image every 3 seconds
    </script>

@endsection
