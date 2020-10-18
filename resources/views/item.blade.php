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
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    @if(session('msg'))
      <div class="alert alert-danger">
          <p> {{session('msg')}} </p>
      </div>
    @endif
    @foreach($hotel as $h)
      <div class="card mt-4" style="margin-bottom:20px">
        <img class="card-img-top img-fluid" src="{{ asset('storage/images/' .$h->foto) }}" width="900px" height="400px" alt="">
        <div class="card-body">
          <hr>
            <h3 class="card-title">{{$h->nama_hotel}}</h3>
          <hr>
            <h4>@php echo "Rp." . number_format($h['harga'], 2, ",", "."); @endphp Permalam</h4>
          <hr>
            <p class="card-text">{{$h->deskripsi}}</p>
            <p class="card-text">Lokasi {{$h->lokasi}}</p>
            <p class="card-text">Tersedia {{$h->kamar}} kamar</p>
          @if(Session::get('login'))
            <hr>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Pesan{{$h->id}}">
              Pesan</button><br>

              <div class="modal fade" id="Pesan{{$h->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pesan {{$h->nama_hotel}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <p>Untuk memesan silahkan isi form Tanggal Check In dan Check Out, kamar dan tempat tidur
                          setelah itu klik hitung harga untuk mendapatkan total harga</p>
                          <form action="/item/order/{{$h->id}}" method="post">
                            @php $maks = intval($h['kamar']) @endphp
                            <label for="">Tanggal Check In</label><br>
                            <input type="date" id="checkin" name="tgl_checkin" required><br>
                            <label for="">Tanggal Check Out</label><br>
                            <input type="date" id="checkout" name="tgl_checkout" required><br>
                            <label for="">Kamar</label><br>
                            <input type="number" id="kamar" name="kamar" min="1" max="@php echo $maks @endphp" required><br>
                            <label for="">Tempat Tidur</label><br>
                            <input type="number"  name="tempat_tidur" min="1" max="2" required><br>
                            <input type="hidden" id="harga_hotel" name="harga_hotel" value="{{$h->harga}}">
                            <label for="">Total Harga</label><br>
                            <input type="text" id="total_harga" name="harga" readonly><br>
                            <label for="">No Rekening</label><br>
                            <p>5221-23123-2112</p>
                            <button type="button" id="hitung" class="btn btn-primary">Hitung Harga</button>
                            <input type="submit" class="btn btn-success" value="Pesan" name="submit">
                            {{ csrf_field() }}
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
          @endif
        </div>
      </div>
    @endforeach
    <!-- /.card -->
  </div>
  <!-- /.col-lg-9 -->

</div>

</div>
<script>
  $(document).ready(function() {
      $('#checkout').on('change', function () {
            if ( ($("#checkin").val() != "") && ($("#checkout").val() != "")) {
                var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
                var firstDate = new Date($("#checkin").val());
                var secondDate = new Date($("#checkout").val());
                var diffDays = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
                var cd = parseInt(diffDays);
            }
            $('#hitung').on('click', function(){
              var harga_hotel = $("#harga_hotel").val();
              var kamar = $("#kamar").val();
              var t1 = 0
              var total = 0;
              if(cd > 1){
                  t1 = parseInt(harga_hotel) * cd;
              }else{
                t1 = parseInt(harga_hotel);
              }

              if(cd > 4){
                t1 = parseInt(harga_hotel) * cd - 50000;
              }
              
              if(kamar > 1){
                  total = t1 * kamar;
              }else{
                total = t1;
              }
              var total_harga = formatRupiah(total, 'Rp.');
              $("#total_harga").val(total_harga);
              $("#harga_hotel").val(total);
            });
      });
  });

  function formatRupiah(angka, prefix){
			var number_string = angka.toString().replace(/[^,\d]/g, ''),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
</script>
<!-- /.container -->

@endsection