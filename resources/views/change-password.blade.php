@extends('layouts.masterapp')
@section('content')
<div id="container_table_merek" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default">
        <div class="panel panel-default panel-body">
            <div class="row">

                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <i class="fas fa-user-tie"></i>&nbsp;&nbsp;Admin&nbsp;</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-sm-12">
                    <div class="panel panel-body">
                          <form id="form_ganti_password" method="post" action="{{ route('change.password.submit') }}">
                            @csrf

                            <div class="form-group">
                                <label for="password_lama">Password Lama</label>
                                <input form="form_ganti_password" transaksi type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Masukkan password lama" required>
                            </div>

                            <div class="form-group">
                                <label for="password_baru">Password Baru</label>
                                <input form="form_ganti_password" transaksi type="password" class="form-control" id="password_baru" name="password_baru" aria-describedby="passwordhelp" placeholder="Masukkan password baru" required>
                                <small id="passwordhelp" class="form-text text-muted">Password boleh menggunakan karakter bebas.</small>
                            </div>

                            <br>

                            <div class="form-check">
                                <input form="form_ganti_password" transaksi type="checkbox" class="form-check-input" id="setuju_ganti_password" name="setuju_ganti_password" required>
                                <label class="form-check-label" for="setuju_ganti_password">Saya setuju akan mengganti password baru.</label>
                            </div>

                            <br>
                            <button type="submit" transaksi id="submit_ganti_password" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
