@extends('admin.index')
@section('content')
<div class="content">
    <div class="animated fadeIn">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">Data Order</strong>
                                </div>
                                <div class="card-body">
                                @if(session('msg'))
                                    <div class="alert alert-success">
                                        <p> {{session('msg')}} </p>
                                    </div>
                                @endif
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Pelanggan</th>
                                                <th>Nama Hotel</th>
                                                <th>Tanggal Check In</th>
                                                <th>Tanggal Check Out</th>
                                                <th>Kamar</th>
                                                <th>Tempat Tidur</th>
                                                <th>Total Harga</th>
                                                <th>Bukti Bayar</th>
                                                <th>Status Check Out</th>
                                                <th>Status Konfirmasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order as $order)
                                            <tr>
                                                <td>{{$order->user->username}}</td>
                                                <td>{{$order->hotel->nama_hotel}}</td>
                                                <td>{{$order->tgl_checkin}}</td>
                                                <td>{{$order->tgl_checkout}}</td>
                                                <td>{{$order->kamar}}</td>
                                                <td>{{$order->tempat_tidur}}</td>
                                                <td>@php echo "Rp." . number_format($order['total_harga'], 2, ",", "."); @endphp</td>
                                                <td><img id="myImg" src="{{ asset('storage/images/' .$order->bukti_bayar) }}"
                                                     width="50px" height="50px" alt="Hotels Image">
                                                </td>
                                                <td>
                                                    @if($order->status_checkout == "")
                                                        -
                                                    @else
                                                        {{$order->status_checkout}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->konfirmasi == "")
                                                        Belum Di Konfirmasi
                                                    @else
                                                        {{$order->konfirmasi}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <form method="post" action="/admin/order/{{$order->id}}">
                                                            {{ csrf_field() }}
                                                            <a href="/admin/detail/{{$order->id}}" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i>Update</a> 
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
    </div>
<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- The Close Button -->
    <span class="close">&times;</span>
    <!-- Modal Content (The Image) -->
    <img class="modal-content" id="img01">
    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
</div>
@endsection