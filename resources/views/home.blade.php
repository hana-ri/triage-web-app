<x-guest-layout>
    <section class="hero vh-100 bg-white">
        <div class="container">
            <div class="row d-flex">
                <div class="col-sm-12 col-md-12 col-lg-6  mt-5">
                    <div class="copy">
                        <div class="text-label text-secondary">Montir Web digitalisasi bisnis Anda ke dalam sebuah
                            website</div>
                        <div class="text-hero-bold text-primary">Sistem Klasifikasi Pasien untuk Gawat Darurat</div>
                        <div class="text-hero-regular text-secondary">Berdasarkan penelitian kehadiran sebuah website
                            dapat
                            memiliki dampak dalam mempengaruhi keputusan pembelian pelanggan!</div>
                        <div class="cta">
                            <a href="{{ route('triage.step.one') }}" class="btn btn-primary">Lakukan triase!</a>
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
