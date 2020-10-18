@extends('index')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3 style="margin-top:20px">Data Order {{Session::get('username')}}</h3>
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
            <div class="alert alert-success">
                <p> {{session('msg')}} </p>
            </div>
            @endif
            <table class="table table-striped">
                <thead>
                    <th>Nama Pelanggan</th>
                    <th>Nama Hotel</th>
                    <th>Tanggal Check In</th>
                    <th>Tanggal Check Out</th>
                    <th>Kamar</th>
                    <th>Tempat Tidur</th>
                    <th>Total Harga</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status Konfirmasi</th>
                    <th>Status Check Out</th>
                    <th>Aksi</th>
                </thead>
                <tbody>    
                    @foreach($order as $order)
                        <tr>
                            <td align="center">{{$order->user->username}}</td>
                            <td align="center">{{$order->hotel->nama_hotel}}</td>
                            <td align="center">{{$order->tgl_checkin}}</td>
                            <td align="center">{{$order->tgl_checkout}}</td>
                            <td align="center">{{$order->kamar}}</td>
                            <td align="center">{{$order->tempat_tidur}}</td>
                            <td align="center">@php echo "Rp." . number_format($order['total_harga'], 2, ",", ".") @endphp</td>
                            <td align="center">
                                @if($order->bukti_bayar == "")
                                    -
                                @else
                                    <img src="{{ asset('storage/images/' .$order->bukti_bayar) }}"
                                        width="100px" height="100px" alt="Bukti Bayar">
                                @endif
                            </td>
                            <td align="center">
                                @if($order->konfirmasi == "")
                                    Diproses
                                @else
                                    {{$order->konfirmasi}}
                                @endif
                            </td>
                            <td align="center">
                                @if($order->status_checkout == "")
                                    -
                                @else
                                    {{$order->status_checkout}}
                                @endif
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-primary" data-toggle="modal" 
                                    data-target="#Pesan{{$order->id}}">Detail</button>
                            </td>
                        </tr>

                        <div class="modal fade" id="Pesan{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Order {{$order->user->username}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h6>Nama Pelanggan : {{$order->user->username}}</h6>
                                    <h6>Nama Hotel : {{$order->hotel->nama_hotel}}</h6>
                                    <h6>Status Upload bukti pembayaran : @if($order->bukti_bayar == "")Belum bayar @else Sudah bayar @endif</h6>
                                    <h6>Status Konfirmasi : @if($order->konfirmasi == "")Belum Dikonfirmasi @else {{$order->konfirmasi}} @endif</h6>
                                    @if($order->konfirmasi == "")
                                        <h6>Upload Bukti Pembayaran</h6>
                                        <h6>No Rekening 5221-23123-2112</h6>
                                    @endif
                                    @if($order->bukti_bayar == "")
                                        <form action="/order/upload/{{$order->id}}" method="post" enctype="multipart/form-data">
                                            <label>Upload File </label><br>
                                            <input type="file" name="bukti_bayar"><br><br>
                                            <input type="submit" class="btn btn-success" value="Upload File" name="submit">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                    @if($order->konfirmasi == "Diterima" && $order->status_checkout == "Belum")
                                        <form action="/order/checkout/{{$order->id}}" method="post">
                                        <input type="hidden" name="kamar" value="{{$order->kamar}}">
                                        <label for="">Silahkan klik tombol checkout jika ingin checkout</label><br>
                                        <input type="submit" class="btn btn-danger" value="Checkout" name="submit">
                                            {{ csrf_field() }}
                                        </form>
                                    @endif
                                </div>
                                </div>
                            </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    
<div class="clearfix"></div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection