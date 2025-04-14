<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Casier - Smart Tech Utama</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('asset/img/myicon1.png') }}" rel="icon">
  <link href="{{ asset('asset/img/myicon1.png') }}" rel="apple-touch-icon">
  

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com'" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('asset/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{asset('asset/css/main.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Updated: Nov 01 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="https://smki-gratis.sch.id/" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{asset('asset/img/logo.png')}}" alt="">
        <h1 class="sitename">SMKI-U</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <ul> 
            @if (Route::has('login'))
                @auth
                    <li>
                        @if(Auth::user()->role_as == 'admin')
                            <a href="{{ url('/admin/dashboard') }}" 
                               class="btn btn-primary d-flex align-items-center justify-content-center" 
                               style="padding: 5px 10px; background-color: #529ada; color: white;">
                               Home
                            </a>
                        @else
                            <a href="{{ url('/kasir/dashboard') }}" 
                               class="btn btn-primary d-flex align-items-center justify-content-center" 
                               style="padding: 5px 10px; background-color: #4698df;">
                               Home
                            </a>
                        @endif
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" 
                           class="btn btn-light d-flex align-items-center justify-content-center" 
                           style="background-color: #4154f1; color: white; border: 1px solid #ccc; padding: 5px 10px;">
                           Get Started
                        </a>
                    </li>
                @endauth
            @endif
        </ul>
           
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Casier Smart Tech-Utama | web developer</h1>
            <p data-aos="fade-up" data-aos-delay="100">A cashier application created to fulfill UKK requirements</p>
            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                <p>&nbsp;</p>
                @if (Route::has('login'))
                @auth
                        @if(Auth::user()->role_as == 'admin')
                            <a href="{{ url('/admin/dashboard') }}" 
                               class="btn btn-primary d-flex align-items-center justify-content-center w-45" 
                               style="padding: 10px 20px; background-color: #529ada; color: white; font-size: 16px;">
                               Kasir SMKI <i class="bi bi-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ url('/kasir/dashboard') }}" 
                               class="btn btn-primary d-flex align-items-center justify-content-center w-45" 
                               style="padding: 10px 20px; background-color: #4698df; color: white; font-size: 16px;">
                               Kasir SMKI <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                @else
                        <a href="{{ route('login') }}" 
                           class="btn btn-light d-flex align-items-center justify-content-center w-45" 
                           style="background-color: #4154f1; color: white; border: 1px solid #ccc; padding: 10px 20px; font-size: 16px;">
                           Kasir SMKI <i class="bi bi-arrow-right"></i>
                        </a>
                @endauth
            @endif
                        </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="{{asset('asset/img/gambar1.png')}}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Values Section -->
    <section id="values" class="values section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
          <h2>Our Products</h2>
          <p>Check out our latest products</p>
      </div><!-- End Section Title -->
  
      <div class="container">
          <div class="row gy-4">
              @foreach($produks as $produk)
                  <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                      <div class="card">
                          <img src="{{ asset('storage/' . $produk->FotoProduk) }}" class="img-fluid" alt="{{ $produk->NamaProduk }}">
                          <h3>{{ $produk->NamaProduk }}</h3>
                          <p>Harga: Rp{{ number_format($produk->Harga, 0, ',', '.') }}</p>
                      </div>
                  </div><!-- End Card Item -->
              @endforeach
          </div>
      </div>
  
  </section><!-- /Products Section -->
  <!-- Stats Section -->

<section id="stats" class="stats section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">

      <div class="col-lg-3 col-md-6">
        <div class="stats-item d-flex align-items-center w-100 h-100">
          <i class="bi bi-emoji-smile color-blue flex-shrink-0"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlah_penjualan }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Happy Clients</p>
          </div>
        </div>
      </div><!-- End Stats Item -->

      <div class="col-lg-3 col-md-6">
        <div class="stats-item d-flex align-items-center w-100 h-100">
          <i class="bi bi-journal-richtext color-orange flex-shrink-0" style="color: #ee6c20;"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlah_produk }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Produks</p>
          </div>
        </div>
      </div><!-- End Stats Item -->

      <div class="col-lg-3 col-md-6">
        <div class="stats-item d-flex align-items-center w-100 h-100">
          <i class="bi bi-people color-pink flex-shrink-0" style="color: #bb0852;"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlah_pelanggan }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Member Premium</p>
          </div>
        </div>
      </div><!-- End Stats Item -->

      <div class="col-lg-3 col-md-6">
        <div class="stats-item d-flex align-items-center w-100 h-100">
          <i class="bi bi-briefcase color-pink flex-shrink-0" style="color: #ee6c20;"></i> <!-- Ganti ikon -->
          <div>
            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlah_user }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Hard Workers</p>
          </div>
        </div>
      </div><!-- End Stats Item -->
      

    </div>
  </div>
</section><!-- /Stats Section -->
    
    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                </p>
                <div class="profile mt-auto">
                  <img src="{{asset('asset/img/testimonials/testimonials-1.jpg')}}" class="testimonial-img" alt="">
                  <h3>Saul Goodman</h3>
                  <h4>Ceo &amp; Founder</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                </p>
                <div class="profile mt-auto">
                  <img src="{{asset('asset/img/testimonials/testimonials-2.jpg')}}" class="testimonial-img" alt="">
                  <h3>Sara Wilsson</h3>
                  <h4>Designer</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                </p>
                <div class="profile mt-auto">
                  <img src="{{asset('asset/img/testimonials/testimonials-3.jpg')}}" class="testimonial-img" alt="">
                  <h3>Jena Karlis</h3>
                  <h4>Store Owner</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                </p>
                <div class="profile mt-auto">
                  <img src="{{asset('asset/img/testimonials/renjun.jpg')}}" class="testimonial-img" alt="">
                  <h3>Matt Brandon</h3>
                  <h4>Freelancer</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                </p>
                <div class="profile mt-auto">
                  <img src="{{asset('asset/img/testimonials/jisung.jpg')}}" class="testimonial-img" alt="">
                  <h3>John Larson</h3>
                  <h4>Entrepreneur</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    {{-- <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Our hard working team</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="{{asset('asset/img/team/team-1.jpg')}}" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Walter White</h4>
                <span>Chief Executive Officer</span>
                <p>Velit aut quia fugit et et. Dolorum ea voluptate vel tempore tenetur ipsa quae aut. Ipsum exercitationem iure minima enim corporis et voluptate.</p>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="{{asset('asset/img/team/team-2.jpg')}}" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Sarah Jhonson</h4>
                <span>Product Manager</span>
                <p>Quo esse repellendus quia id. Est eum et accusantium pariatur fugit nihil minima suscipit corporis. Voluptate sed quas reiciendis animi neque sapiente.</p>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member">
              <div class="member-img">
                <img src="{{asset('asset/img/team/team-3.jpg')}}" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>William Anderson</h4>
                <span>CTO</span>
                <p>Vero omnis enim consequatur. Voluptas consectetur unde qui molestiae deserunt. Voluptates enim aut architecto porro aspernatur molestiae modi.</p>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
            <div class="team-member">
              <div class="member-img">
                <img src="{{asset('asset/img/team/team-4.jpg')}}" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Amanda Jepson</h4>
                <span>Accountant</span>
                <p>Rerum voluptate non adipisci animi distinctio et deserunt amet voluptas. Quia aut aliquid doloremque ut possimus ipsum officia.</p>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section --> --}}

  </main>

  <footer id="footer" class="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">Casier Smart Tech-Utama</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
        </div>

     
        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <div class="credits"></div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="https://cdn.jsdelivr.net/npm/purecounterjs@1.0.2/dist/purecounter_vanilla.js"></script>
  <script>
    new PureCounter();
  </script>
  
  <!-- Vendor JS Files -->
  <script src="{{asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('asset/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('asset/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('asset/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('asset/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('asset/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('asset/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('asset/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('asset/js/main.js')}}"></script>

</body>

</html>