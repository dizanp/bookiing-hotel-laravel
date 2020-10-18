@extends('admin.index')
@section('content')
<div class="content">
            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Detail Order </strong>
                            </div> 
                            <div class="card-body card-block">
                                @if(count($errors) >0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li> {{$error}} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <table class="table table-striped">
                                    <tr>
                                        <td>Nama Pelanggan</td>
                                        <td>:</td>
                                        <td>{{$order->user->username}}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Hotel</td>
                                        <td>:</td>
                                        <td>{{$order->hotel->nama_hotel}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kamar</td>
                                        <td>:</td>
                                        <td>{{$order->kamar}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Konfirmasi</td>
                                        <td>:</td>
                                        <td>
                                            @if($order->konfirmasi == "")
                                                Belum di konfirmasi
                                            @else
                                                {{$order->konfirmasi}}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @if($order->konfirmasi == "")
                                    <form action="/admin/detail/{{$order->id}}" method="post" >
                                        <label for="">Konfirmasi Pesanan</label><br>
                                        Diterima<input type="radio" name="konfirmasi" value="Diterima">
                                        Ditolak<input type="radio" name="konfirmasi" value="Ditolak">
                                        <input type="hidden" name="kamar" value="{{$order->kamar}}"><br>
                                        <input type="submit" name="submit" class="btn btn-success btn-md" value="Update">
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                                @if($order->konfirmasi == "Diterima")
                                    <form action="/admin/detail/{{$order->id}}">
                                        <input type="submit" name="submit" class="btn btn-danger btn-md" value="Checkout">
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

  </div>


</div><!-- .animated -->
</div><!-- .content -->
@endsection