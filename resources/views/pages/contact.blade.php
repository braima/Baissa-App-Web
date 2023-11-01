@extends('layouts.frontend.app')

@push('css')
@endpush

@section('content')

    @include('layouts.frontend.partial.header')
    

    <section id="contact" class="contact section-padding">
      <div class="container">

        <div class="row gx-0">
          <div class="col-lg-12 d-flex flex-column justify-content-center text-center">
            <div class="content">
              <h1><span> Contactez-nous</span></h1>
            </div>
          </div>
        </div>

        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Address</h3>
                  <p>Mag Plle N° 1826 Hay Assalam - Agadir<br>Agadir, 80000 Maroc</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-telephone"></i>
                  <h3>Appelez-nous</h3>
                  <p>+212 (0) 528 22 18 62<br>+212 (0) 618 47 96 20</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-envelope"></i>
                  <h3>Envoyez-nous un email</h3>
                  <p>contact@baissa.com</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-clock"></i>
                  <h3>Heures d'ouverture</h3>
                  <p>Lundi - Dimanche<br>09:00 - 22:00</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
          @include('layouts.messages')
            <form action="mailtoteacher" method="post" class="php-email-form">
              {{ csrf_field() }}
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="fullname" class="form-control" placeholder="Nom Complet" required>
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="object" placeholder="Sujet" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>

              </div>
            </form>

          </div>

        </div>

      </div>
    </section>

    <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24663.769893180994!2d-9.567129572214723!3d30.40146160110974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzDCsDI0JzAxLjkiTiA5wrAzMic0Ni41Ilc!5e0!3m2!1sfr!2sma!4v1635873310165!5m2!1sfr!2sma" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>

    @include('layouts.frontend.partial.footer')

@endsection

@push('js')
	
@endpush
