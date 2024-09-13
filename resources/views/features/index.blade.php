@extends('layouts.layout')

@section('content')
    <section>
        <h1 class="multimedia-gallery">Multimedia Gallery</h1>
        <div class="gallery">
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/1.JPG') }}" alt="Wayang Krucil 1">
                <div class="description">
                    "Wayang Krucil" terbuat dari kayu dan dimainkan oleh dalang di panggung kecil. Ceritanya menampilkan
                    kisah epik dan sejarah, khususnya cerita Panji dari Jawa Timur. Wayang ini menggambarkan kehidupan
                    masyarakat Jawa di masa lalu.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/2.JPG') }}" alt="Wayang Suket">
                <div class="description">"Wayang Suket" terbuat dari rumput alang-alang yang dijalin dan dibentuk menyerupai
                    tokoh wayang Purwa. Dikenal sejak tahun 1920-an di Jawa Tengah, wayang ini digunakan sebagai alat
                    permainan dan penyampaian cerita pewayangan pada anak-anak. Karena bahan yang mudah rusak, wayang ini
                    tidak bertahan lama.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/3.JPG') }}" alt="Wayang Kaca">
                <div class="description">"Wayang Kaca" adalah lukisan wayang dengan teknik terbalik dari belakang kaca yang
                    berkembang sejak abad ke-17 di Jawa. Lukisan ini biasanya menggambarkan wayang atau kaligrafi dan masih
                    dilestarikan di beberapa daerah.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/4.JPG') }}" alt="Wayang Golek Menak">
                <div class="description">"Wayang Golek Menak" terbuat dari kayu dan menggunakan cerita dari Serat Menak.
                    Wayang golek di Jawa dipengaruhi oleh boneka Cina seperti wayang Potehi. Sunan Kudus disebut
                    menciptakannya pada tahun 1584, dan kini wayang ini masih digunakan dalam pertunjukan seni.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/5.JPG') }}" alt="Wayang Tengger">
                <div class="description">"Wayang Tengger" merupakan wayang kulit yang membawakan kisah Ramayana dan
                    Mahabharata. Pada lakon cerita Panji, peran tokoh-tokoh wayang ini berubah, seperti Arjuna menjadi Panji
                    Asmorobangun. Kini, wayang ini jarang digunakan dalam upacara-upacara di daerah Tengger Semeru.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/6.JPG') }}" alt="Wayang Kancil">
                <div class="description">"Wayang Kancil"adalah varian wayang kulit yang berperan dalam menceritakan lakon
                    Ramayana dan Mahabharata. Wayang ini digunakan oleh suku Tengger dalam berbagai upacara tradisional.
                    Kini, penggunaannya dalam upacara semakin jarang ditemukan.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/7.JPG') }}" alt="Wayang Debog">
                <div class="description">"Wayang Debog" terbuat dari pelepah pisang yang diproses hingga tipis dan keras
                    seperti kertas. Wayang ini ditemukan di pedalaman Blitar dan diperkirakan berusia hampir 100 tahun.
                    Bentuknya menggambarkan raksasa dengan ornamen tumbuhan dan hewan.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/8.JPG') }}" alt="Wayang Suluh">
                <div class="description">"Wayang Suluh" diciptakan setelah Proklamasi 1945 untuk penyuluhan program
                    pemerintah. Pementasan pertama diadakan di Madiun pada tahun 1947 dan menggunakan tokoh-tokoh sejarah
                    Indonesia. Wayang ini dipentaskan dengan musik gamelan dan bahasa yang mudah dipahami rakyat.</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/features/images-feature/9.JPG') }}" alt="Blawong">
                <div class="description">"Blawong" adalah tempat untuk menyimpan keris lengkap dengan warangkanya. Biasanya
                    digantung di dinding sebagai pajangan atau hiasan. Blawong menjadi simbol penting dalam budaya keris
                    tradisional.</div>
            </div>
        </div>
    </section>

    <!-- Embed Artsteps 3D -->
    <section>
        <h2 class="text-2xl font-semibold text-center">Explore 3D Virtual Gallery</h2>
        <div class="artsteps-embed overflow-hidden rounded-lg">
            <iframe width="100%" height="800" class="px-5 py-5 rounded-md" src="https://www.artsteps.com/embed/66deab296bc6dee4af3515bc/1280/720"
                frameborder="0" allowfullscreen></iframe>
        </div>
    </section>
@endsection
