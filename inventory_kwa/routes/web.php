<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

Route::get('session/login', [SessionController::class, 'createSession']);
Route::get('session/logout', [SessionController::class, 'deleteSession']);

Route::group(['middleware'=>['afterMiddleware']], function () {
	Route::get('/', function () {
		return view('login');
	});
});

Route::group(['middleware'=>['beforeMiddleware']], function () {
	Route::get('dashboard', function () {
		return view('dashboard');
	});
	Route::get('posisi-stok-material', function () {
		return view('posisi-stok-material');
	});
	Route::get('posisi-stok-alker', function () {
		return view('posisi-stok-alker');
	});

	Route::group(['middleware'=>['adminMiddleware']], function () {
		Route::get('create/main-alker', function () {
			return view('create-main-alker');
		});
		Route::get('main-alker/{id}', function () {
			return view('edit-main-alker');
		});

		Route::get('create/tool/{id}', function () {
			return view('create-tool');
		});
		
		Route::get('material', function () {
			return view('material');
		});
		Route::get('create/material', function () {
			return view('create-material');
		});
		Route::get('material/{id}', function () {
			return view('edit-material');
		});

		Route::get('teknisi', function () {
			return view('teknisi');
		});
		Route::get('create/teknisi', function () {
			return view('create-teknisi');
		});
		Route::get('teknisi/{id}', function () {
			return view('edit-teknisi');
		});

		Route::get('supplier', function () {
			return view('supplier');
		});
		Route::get('create/supplier', function () {
			return view('create-supplier');
		});
		Route::get('supplier/{id}', function () {
			return view('edit-supplier');
		});
	});

	Route::group(['middleware'=>['warehouseMiddleware']], function () {
		Route::get('approve-alker', function () {
			return view('approve-alker');
		});
		Route::get('approve-alker/{id}', function () {
			return view('edit-approve-alker');
		});

		Route::get('approve-barang', function () {
			return view('approve-barang');
		});
		Route::get('approve-barang/{id}', function () {
			return view('edit-approve-barang');
		});
	});

	Route::group(['middleware'=>['managerMiddleware']], function () {
		Route::get('alker', function () {
			return view('alker');
		});
		Route::get('alker/{id}', function () {
			return view('view-alker');
		});
		Route::get('create/alker', function () {
			return view('create-alker');
		});

		Route::get('create/project', function () {
			return view('create-project');
		});

		Route::get('create/pengadaan-request', function () {
			return view('create-pengadaan-request');
		});
		Route::get('pengadaan-request/{id}', function () {
			return view('edit-pengadaan');
		});
	});

	Route::group(['middleware'=>['adminPengadaanMiddleware']], function () {
		Route::get('main-alker', function () {
			return view('main-alker');
		});
		Route::get('tool/{id}', function () {
			return view('view-tool');
		});
		Route::get('tool/detail/{id}', function () {
			return view('detail-tool');
		});
	});

	Route::group(['middleware'=>['warehousePengadaanMiddleware']], function () {
		Route::get('pengadaan-request', function () {
			return view('pengadaan-request');
		});
	});

	Route::group(['middleware'=>['managerPengadaanMiddleware']], function () {
		Route::get('project', function () {
			return view('project');
		});
		Route::get('project/{id}', function () {
			return view('edit-project');
		});
	});

	Route::group(['middleware'=>['reviewPengadaanMiddleware']], function () {
		Route::get('pengadaan-review', function () {
			return view('pengadaan-review');
		});
		Route::get('create/pengadaan-review', function () {
			return view('create-pengadaan-review');
		});
	});
});

Route::get('alker/detail/{id}', function () {
	return view('detail-alker');
});
