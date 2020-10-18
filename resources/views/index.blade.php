<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mr Booking</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('css/shop-homepage.css')}}" rel="stylesheet">
  <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
 
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Mr Booking</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/data">Hotel</a>
          </li>
          @if(!Session::get('login'))
            <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/register">Register</a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown">{{Session::get('username')}}</a>
              <ul class="dropdown-menu">
                <li><a href="/logout">Logout</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/order">Order</a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  @if(View::hasSection('content'))
      @yield('content')
  @else
    <div class="container">

        <div class="row">

        <div class="col-lg-3">            
            <div class="card" style="width: 15rem;margin-top:40px">
                <div class="card-body">
                    <h5 class="card-title">Search</h5>
                    <form action="/seach" method="post">
                        <label for="">Tujuan</label><br>
                        <input type="text" name="search" placeholder="location"><br><br>
                        <input type="submit" name="submit" class="btn btn-success" value="Search">
                    </form>
                </div>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                <img class="d-block img-fluid" src="{{asset('images/h1.jpg')}}" width="900px" height="300px" alt="First slide">
                </div>
                <div class="carousel-item">
                <img class="d-block img-fluid" src="{{asset('images/h2.jpg')}}" width="900px" height="300px" alt="Second slide">
                </div>
                <div class="carousel-item">
                <img class="d-block img-fluid" src="{{asset('images/h3.jpg')}}" width="900px" height="300px" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>

            <div class="row">


            @foreach($hotel as $h)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                <a href="#"><img class="card-img-top" src="{{ asset('storage/images/' .$h->foto) }}" width="200px" height="150px" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                    <a href="/item/{{$h->slug}}">{{$h->nama_hotel}}</a>
                    </h4>
                    <p class="card-text">{{substr($h->deskripsi, 0 ,30)}}...</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted"><h6>@php echo "Rp." . number_format($h['harga'], 2, ",", "."); @endphp Permalam</h6></small>
                </div>
                </div>
            </div>
            @endforeach

         </div>
         <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
   @endif

  <!-- Footer -->
  <footer class="py-5 bg-success">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Mr Booking @php echo date('Y') @endphp</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>

</html>
