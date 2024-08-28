@extends('layouts.layout')

@section('content')
    <section class="page-1-all">
        <div class="page-1-description">
            <h1>Kenalan yuk sama cerita Panji dari Wayang Krucil.</h1>
            <p>Males gasih baca artikel tentang cerita panji?<br>Duduk sini deh, aku bakalan ceritain!</p>
            <div class="page-1-button-flex">
                <a href="{{ route('chat') }}" class="page-1-start-chat">Start Chat!</a>
                <a class="page-1-more-features" href="">More Features</a>
            </div>
        </div>
        <figure class="chatbot-img">
            <img src="{{ asset('assets/images/chatbot-img.png') }}" alt="Chatbot image">
        </figure>
    </section>

    <aside class="verification">
        <p>Verified by:</p>
        <a href="https://www.museumpanji.com/" target="_blank" aria-label="Museum Panji website">
            <img class="museum-panji-logo" src="{{ asset('assets/images/museum-panji-verified.png') }}"
                alt="Museum Panji logo">
        </a>
    </aside>

    <section class="page-2">
        <div class="feature-desc">
            <h2>All-In One</h2>
            <p>Waykru bukan cuman sekedar AI Chatbot biasa, <br>
                dia bakalan nyediain berbagai fitur-fitur interaktif dan menarik juga!</p>
        </div>
        <div class="container">
            <div class="card__container">
                <article class="card__article">
                    <img src="{{ asset('assets/images/Multimedia Gallery.jpg') }}" alt="Multimedia Gallery"
                        class="card__img">
                    <div class="card__data">
                        <span class="card__description">Feature</span>
                        <h2 class="card__title">Multimedia Gallery</h2>
                        <a href="#" class="card__button">See more</a>
                    </div>
                </article>
                <article class="card__article">
                    <img src="{{ asset('assets/images/Chatbot.jpg') }}" alt="Waykru Chatbot" class="card__img">
                    <div class="card__data">
                        <span class="card__description">Feature</span>
                        <h2 class="card__title">Waykru Chatbot</h2>
                        <a href="#" class="card__button">See More</a>
                    </div>
                </article>
                <article class="card__article">
                    <img src="{{ asset('assets/images/Virtual Tour.jpg') }}" alt="E-learning Modules" class="card__img">
                    <div class="card__data">
                        <span class="card__description">Feature</span>
                        <h2 class="card__title">E-learning Modules</h2>
                        <a href="#" class="card__button">See More</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="page-3">
        <div class="page-3-title">
            <h2>Berita Terkait</h2>
        </div>
        <div class="container2">
            <div class="news-container">
                <div class="news-header-container">
                    <p>Senin, 20 Mei 2024</p>
                    <a href="">News</a>
                </div>
                <div class="news-image">
                    <img src="{{ asset('assets/images/foto-news-pertama.jpg') }}" alt="Wayang Krucil Sidorejo">
                </div>
                <div class="news-headline">
                    <h2>WAYANG KRUCIL SIDOREJO, KESENIAN YANG PUNAH</h2>
                    <h3>Mendengar nama kesenian wayang, mungkin secara umum pikiran masyarakat akan langsung tertuju
                        kepada kesenian wayang kulit, wayang golek, atau wayang orang. Karena, sebagian masyarakat
                        mungkin tidak atau belum mengetahui bahwa masih ada satu lagi jenis kesenian wayang, yakni
                        kesenian Wayang Krucil.</h3>
                    <a target="_blank"
                        href="https://radarkediri.jawapos.com/features/784405670/profil-desa-senden-kayenkidul-kabupaten-kediri-upaya-melestarikan-kesenian-wayang-krucil-agar-tidak-punah?page=2">Read
                        More</a>
                </div>
            </div>
            <div class="news-container">
                <div class="news-header-container">
                    <p>Sabtu, 5 November 2022</p>
                    <a href="">News</a>
                </div>
                <div class="news-image">
                    <img src="{{ asset('assets/images/foto-news-kedua.jpg') }}"
                        alt="Wayang Krucil, Wayang Kayu Yang Jarang Dikenal">
                </div>
                <div class="news-headline">
                    <h2>Wayang Krucil, Wayang Kayu Yang Jarang Dikenal</h2>
                    <h3>Hari ke-4 Pekan Wayang Jawa Timur 2022 dipergelarkan satu wayang kayu yang biasa disebut
                        wayang krucil atau ada juga yang menyebut wayang klithik.</h3>
                    <a target="_blank"
                        href="https://cakdurasim.com/pergelaran/wayang-krucil-wayang-kayu-yang-jarang-dikenal">Read
                        More</a>
                </div>
            </div>
            <div class="news-container">
                <div class="news-header-container">
                    <p>Selasa, 05 September 2023</p>
                    <a href="">News</a>
                </div>
                <div class="news-image">
                    <img src="{{ asset('assets/images/foto-news-ketiga.jpg') }}"
                        alt="Seorang Pemuda Berhasil Sulap Limbah Kayu Jati Menjadi Kerajinan Wayang Krucil Bernilai Seni Tinggi">
                </div>
                <div class="news-headline">
                    <h2>Seorang Pemuda Berhasil Sulap Limbah Kayu Jati Menjadi Kerajinan Wayang Krucil Bernilai Seni
                        Tinggi</h2>
                    <h3>“ini membuat wayang krucil, sudah lama sejak lulus SMP, bahannya limbah kayu jati,
                        pemesannya banyak dari luar daerah, pokoknya saya posting di facebook lalu...</h3>
                    <a href="">Read More</a>
                </div>
            </div>
        </div>
        <div class="more-news-btn">
            <a href="">More News</a>
        </div>
    </section>

    <section class="page-4">
        <div class="page-4-title">
            <h2>Cerita Panji</h2>
        </div>
        <div class="title-description">
            <p>Tonton lebih banyak tentang Cerita Panji yuk, biar lebih paham</p>
        </div>
        <div class="video-container">
            <video id="my-video" class="video" controls>
                <source src="{{ asset('assets/videos/IRARI VLOG- Raka Praska - Wayang Krucil Dari Bumi Panji.mp4') }}"
                    type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="video-button">
            <a href="">More Videos</a>
        </div>
    </section>
@endsection
