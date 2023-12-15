@extends('layouts.main_admin')

@section('manage_transactions')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2>History Transaksi</h2>
            <div class="table-responsive">
                <table class="table table-dark custom-table">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama Customer</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Estimasi</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($htrans as $item)
                            <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ DB::table('users')->where('id', $item->users_id)->first()->name }}</td>
                                <td>{{ DB::table('pengirimans')->where('id', $item->pengirimans_id)->first()->lokasi }}</td>
                                <td>{{ 'Rp. ' . number_format($item->subtotal, 0) }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->ctr_estimasi . ' hari lagi sampai' }}</td>
                                <td>
                                    <button class="btn btn-secondary" type="button" data-toggle="collapse"
                                        data-target=".collapse{{ $item->kode }}" aria-expanded="false"
                                        aria-controls="collapse{{ $item->kode }}">
                                        Detail Pesanan <i class="bi bi-chevron-down"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="collapse collapse{{ $item->kode }}">
                                        <table class="table table-dark">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Htrans Kode</th>
                                                    <th scope="col">Nama Barang</th>
                                                    <th scope="col">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $dtransRecords = DB::table('dtrans')
                                                        ->where('htrans_kode', $item->kode)
                                                        ->get();
                                                @endphp
                                                @foreach ($dtransRecords as $dtrans)
                                                    <tr>
                                                        <td>{{ $dtrans->htrans_kode }}</td>
                                                        <td>{{ DB::table('products')->where('id', $dtrans->products_id)->first()->nama }}
                                                        </td>
                                                        <td>{{ $dtrans->qty }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .custom-table {
            width: 100%;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.collapse').on('show.bs.collapse', function() {
                $('.collapse.show').not($(this)).collapse('hide');
            });
        });
    </script>
@endsection
