@extends('layouts.layout')

@section('title', 'About Us')

@section('content')


    <section class="py-14 lg:py-24 relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative ">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-9">
                <div class="img-box">
                    <img src="{{ asset('images/B7-1024x683.jpg') }}" alt="About Us tailwind page"
                        class="max-lg:mx-auto object-cover">
                </div>
                <div class="lg:pl-[100px] flex items-center">
                    <div class="data w-full">
                        <h2 class="font-manrope font-bold text-4xl lg:text-5xl text-black mb-9 max-lg:text-center relative">
                            Who We Are</h2>
                        <p class="font-normal text-xl leading-8 text-gray-500 max-lg:text-center max-w-2xl mx-auto">
                            At Mihintale Circuit Bungalow, we pride ourselves on providing a warm and welcoming retreat for
                            travelers seeking to explore the historic charm of Mihintale. Our bungalow is designed to offer
                            comfort, convenience, and a peaceful atmosphere, making it the ideal destination for families,
                            friends, and solo adventurers alike. With a focus on exceptional service and affordable
                            accommodations, we strive to make every guest feel at home.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 lg:py-24 relative">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative ">
            <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-9 ">

                <div class="lg:pr-24 flex items-center">
                    <div class="data w-full">
                        <img src="https://pagedone.io/asset/uploads/1702034785.png" alt="About Us tailwind page"
                            class="block lg:hidden mb-9 mx-auto object-cover">
                        <h2 class="font-manrope font-bold text-4xl lg:text-5xl text-black mb-9 max-lg:text-center">Our
                            Mission</h2>
                        <p class="font-normal text-xl leading-8 text-gray-500 max-lg:text-center max-w-2xl mx-auto">
                            Our mission is to create memorable experiences by offering a perfect balance of relaxation and
                            accessibility. We are dedicated to preserving the serene beauty of Mihintale while providing
                            modern amenities and personalized care to our guests. Whether you're visiting for spiritual
                            exploration or a peaceful getaway, Mihintale Circuit Bungalow is here to make your stay truly
                            unforgettable.
                        </p>
                    </div>
                </div>
                <div class="img-box ">
                    <img src="{{ asset('images/IMG_6584.jpg') }}" alt="About Us tailwind page"
                        class="hidden lg:block object-cover">
                </div>
            </div>
        </div>
    </section>

@endsection
