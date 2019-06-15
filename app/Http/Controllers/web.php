<?php


Auth::routes();
Route::get('/', 'HomeController@index');



Route::resource('/user', 'UserController');
Route::get('all/user', 'UserController@AllUser')->name('all.user');

Route::middleware(['auth'])->group(function(){



  Route::get('/home', 'HomeController@index')->name('home');

  Route::middleware('role:admin')->group(function(){
    Route::resource('supplier', 'SupplierController');
    Route::get('all/supplier', 'SupplierController@AllSupplier')->name('all.supplier');
    Route::resource('brand', 'BrandController');
  });

  Route::middleware('role:gudang')->group(function(){

    Route::resource('pembelian', 'PembelianController');
    Route::get('histori-pembelian', 'PembelianController@HistoriPembelian');
    Route::get('all/purchase', 'PembelianController@AllPurchase')->name('all.purchase');
    Route::get('/create-purchase/{id}', 'PembelianController@CreateSession');
    Route::post('/update/purchase', 'PembelianController@UpdatePembelian')->name('update.purchase.submit');

  });


  Route::resource('unit', 'UnitController');
  Route::post('/check/listunit', 'UnitController@AllUnit')->name('check.list_unit');
  Route::post('/detailunit/store', 'UnitController@StoreDetailUnit')->name('store.detailunit.submit');
  Route::resource('category', 'CategoryController');
  Route::get('/all/category', 'CategoryController@AllCategory')->name('all.category');
  Route::resource('combo', 'ComboController');
  Route::get('/all/combo', 'ComboController@AllCombo')->name('all.combo');
  Route::get('export/combo', 'ComboController@ExportCombo')->name('combo.export');

  Route::get('/all/brand', 'BrandController@AllBrand')->name('all.brand');



  Route::get('laporan', 'LaporanController@index');
  Route::post('export/penjualan', 'LaporanController@ExportPenjualan')->name('penjualan.export');
  Route::post('export/pembelian', 'LaporanController@ExportPembelian')->name('pembelian.export');
  Route::post('export/good', 'LaporanController@ExportGood')->name('good.export');

  Route::resource('customer', 'CustomerController');
  Route::get('all/customer', 'CustomerController@AllCustomer')->name('all.customer');

  Route::resource('good', 'GoodController');
  Route::get('/all/good_no_combo', 'GoodController@AllGoodNoCombo')->name('all.goodnocombo');
  Route::get('/all/good_detail', 'GoodController@AllGoodDetail')->name('all.gooddetail');
  Route::post('/check/detail_unit', 'GoodController@CheckDetailUnit')->name('check.detail_unit');
  Route::get('/all/good', 'GoodController@AllGood')->name('all.good');
  Route::post('/good/savetabelbarang', 'GoodController@saveTableBarang')->name('good.save.form');
  Route::post('/good/checkkode', 'GoodController@checkKode')->name('check.kode');
  Route::post('/good/hapus_cookie_barang', 'GoodController@hapusCookie')->name('hapus.cookie_barang');
  Route::post('/import/good', "GoodController@ImportGood")->name('good.import');
  Route::get('/export/good', 'GoodController@ExportGood')->name('good.export');


  Route::resource('penjualan', 'PenjualanController');
  Route::get('/all/find_customer', 'PenjualanController@FindCustomer')->name('all.find_customer');
  Route::post('customer/store', 'PenjualanController@SimpanPelanggan')->name('simpan.pelanggan.submit');
  Route::post('/update/sales', 'PenjualanController@UpdatePenjualan')->name('update.sale.submit');
  Route::get('histori-penjualan', 'PenjualanController@HistoriPenjualan');
  Route::get('all/sales', 'PenjualanController@AllSales')->name('all.sales');
  Route::get('/create-sales/{id}', 'PenjualanController@CreateSession');
});

Route::get('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');






//



Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
      Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    // Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});
