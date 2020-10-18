@extends('index')
@section('content')
<!-- Page Content -->
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
            <div class="row">
                <div class="col-md-12" style="margin-top:40px; margin-bottom:20px">
                @foreach($hotel as $h)
                <div class="card flex-row flex-wrap" style="margin-top:10px; margin-bottom:5px">
                    <div class="card-header border-0">
                        <img src="{{ asset('storage/images/' .$h->foto) }}" width="200px" height="200px" alt="gambar">
                    </div>
                    <div class="card-block px-2">
                        <h4 class="card-title">{{$h->nama_hotel}}</h4>
                        <p class="card-text">{{substr($h->deskripsi, 0 ,70)}}...</p>
                        <p>@php echo "Rp." . number_format($h['harga'], 2, ",", "."); @endphp Permalam</p>
                        <a href="/item/{{$h->slug}}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
                @endforeach
                </div>
                <div col-md-12>
                    <ul class="pagination">
                        <li class="page-item">{!! $hotel->links() !!}</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /.col-lg-9 -->    
    </div>
</div>
@endsection
