<?php



Auth::routes();


Route::get('/', 'HomeController@index');

Route::get('/home',function(){

  if(auth()->user()->hasRole('gudang')){
    return redirect('good');
  }

  elseif(auth()->user()->hasRole('user')){
    return redirect('penjualan');
  }

  else {
    return redirect('penjualan');
  }


})->name('home');

Route::middleware(['auth'])->group(function(){

  Route::group(['middleware' => ['role:admin']], function(){
      Route::get('/admin', 'AdminController@index');
      Route::resource('/user', 'UserController');
      Route::get('all/user', 'UserController@AllUser')->name('all.user');

      Route::get('laporan', 'LaporanController@index');
      Route::post('export/penjualan', 'LaporanController@ExportPenjualan')->name('penjualan.export');
      Route::post('export/pembelian', 'LaporanController@ExportPembelian')->name('pembelian.export');
      Route::post('export/good', 'LaporanController@ExportGood')->name('good.export');
  });

  Route::group(['middleware' => ['role:admin|gudang']], function(){
    Route::resource('pembelian', 'PembelianController');
    Route::get('histori-pembelian', 'PembelianController@HistoriPembelian');
    Route::get('all/purchase', 'PembelianController@AllPurchase')->name('all.purchase');
    Route::get('/create-purchase/{id}', 'PembelianController@CreateSession');
    Route::post('/update/purchase', 'PembelianController@UpdatePembelian')->name('update.purchase.submit');
    Route::post('batalkan-update-pembelian', 'PembelianController@DestroyUpdatePembelian')->name('batalkan.update.pembelian');
    Route::get('/all/good_no_combo', 'GoodController@AllGoodDetail')->name('all.gooddetail');
    Route::resource('supplier', 'SupplierController');
    Route::get('all/supplier', 'SupplierController@AllSupplier')->name('all.supplier');

    Route::resource('brand', 'BrandController');
    Route::get('/all/brand', 'BrandController@AllBrand')->name('all.brand');

    Route::resource('category', 'CategoryController');
    Route::get('/all/category', 'CategoryController@AllCategory')->name('all.category');

    Route::resource('unit', 'UnitController');
    Route::post('/detailunit/store', 'UnitController@StoreDetailUnit')->name('store.detailunit.submit');

    Route::resource('combo', 'ComboController');
    Route::get('/all/combo', 'ComboController@AllCombo')->name('all.combo');
    Route::get('export/combo', 'ComboController@ExportCombo')->name('combo.export');

    Route::get('/all/good', 'GoodController@AllGood')->name('all.good');
    Route::post('/good/checkkode', 'GoodController@checkKode')->name('check.kode');
    Route::post('/good/hapus_cookie_barang', 'GoodController@hapusCookie')->name('hapus.cookie_barang');
    Route::resource('good', 'GoodController');
    Route::get('/all/good_no_combo', 'GoodController@AllGoodNoCombo')->name('all.goodnocombo');
    Route::post('/check/detail_unit', 'GoodController@CheckDetailUnit')->name('check.detail_unit');
    Route::get('/all/good', 'GoodController@AllGood')->name('all.good');
    Route::post('/good/savetabelbarang', 'GoodController@saveTableBarang')->name('good.save.form');
    Route::post('/good/checkkode', 'GoodController@checkKode')->name('check.kode');
    Route::post('/good/hapus_cookie_barang', 'GoodController@hapusCookie')->name('hapus.cookie_barang');
    Route::post('/import/good', "GoodController@ImportGood")->name('good.import');
    Route::get('/export/good', 'GoodController@ExportGood')->name('good.export');
  });

  Route::group(['middleware' => ['role:admin|user']], function(){
    Route::resource('penjualan', 'PenjualanController');
    Route::get('/all/good_detail', 'GoodController@AllGoodDetail')->name('all.gooddetail');
    Route::get('/all/find_customer', 'PenjualanController@FindCustomer')->name('all.find_customer');
    Route::post('customer/store', 'PenjualanController@SimpanPelanggan')->name('simpan.pelanggan.submit');
    Route::resource('penjualan', 'PenjualanController');
    Route::post('/update/sales', 'PenjualanController@UpdatePenjualan')->name('update.sale.submit');
    Route::get('histori-penjualan', 'PenjualanController@HistoriPenjualan');
    Route::get('all/sales', 'PenjualanController@AllSales')->name('all.sales');
    Route::get('/create-sales/{id}', 'PenjualanController@CreateSession');
    Route::resource('customer', 'CustomerController');
    Route::get('all/customer', 'CustomerController@AllCustomer')->name('all.customer');
    Route::post('batalkan-update-penjualan', 'PenjualanController@DestroyUpdatePenjualan')->name('batalkan.update.penjualan');
  });

  Route::post('/check/listunit', 'UnitController@AllUnit')->name('check.list_unit');
  Route::get('change-password', 'PasswordController@index')->name('change.password');
  Route::post('/submit/password', 'PasswordController@SimpanPassword')->name('change.password.submit');

});
