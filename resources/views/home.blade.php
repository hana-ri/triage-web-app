<x-guest-layout>
    <x-slot:title>Beranda</x-slot:title>
    <section class="hero vh-100 bg-white">
        <div class="container">
            <div class="row d-flex">
                <div class="col-sm-12 col-md-12 col-lg-6  mt-5">
                    <div class="copy">
                        <div class="text-label text-secondary">Aplikasi Web Klasifikasi Level Triase</div>
                        <div class="text-hero-bold text-primary">Klasifikasi Level Triase untuk Pasien Installasi Gawat Darurat</div>
                        <div class="text-hero-regular text-secondary">Mungkin sistem triase tidak sesederhana sistem antrian (<p class="fst-italic d-inline">first come first serve</p>), tapi ini diperlukan ketika IGD  untuk memperlakukan pasien secara adil sesuai dengan gejala yang dialami pasien.</div>
                        <div class="cta">
                            @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-5 d-none d-sm-none d-md-none d-lg-block">
                    <img src="{{ asset('assets/images/hero_medicine.svg') }}" alt="hero-img" width="600px">
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
