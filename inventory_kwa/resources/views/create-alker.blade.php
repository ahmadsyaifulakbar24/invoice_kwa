@extends('layouts/app')

@section('title','Tambah Alker/Salker')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-10 offset-xl-2 offset-lg-1">
				<h5 class="pb-2">Tambah Alker/Salker</h5>
				<div class="card card-custom hide" id="data">
					<form id="form" class="card-body">
						<div class="form-group row">
							<label for="keterangan_id" class="col-lg-4 col-md-5 col-form-label">Keterangan</label>
							<div class="col-lg-8 col-md-7">
								<select id="keterangan_id" class="custom-select" role="button">
									<option disabled selected>Pilih</option>
								</select>
								<div class="invalid-feedback" id="keterangan_id-feedback"></div>
							</div>
						</div>
						<div class="form-group row">
							<label for="alker_id" class="col-lg-4 col-md-5 col-form-label">Alker/Salker</label>
							<div class="col-lg-8 col-md-7">
								<select id="alker_disabled" class="custom-select" disabled>
									<option selected>Pilih</option>
								</select>
								<div id="alker_id" data-id="null" class="custom-select text-truncate hide" data-toggle="modal" data-target="#modal-alker" role="button">Pilih</div>
								<div class="invalid-feedback" id="alker_id-feedback"></div>
							</div>
						</div>
						<div id="form_ng">
							<div class="form-group row">
								<label for="sto_id" class="col-lg-4 col-md-5 col-form-label">STO</label>
								<div class="col-lg-8 col-md-7">
									<select id="sto_id" class="custom-select" role="button">
										<option disabled selected>Pilih</option>
									</select>
									<div class="invalid-feedback" id="sto_id-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label for="teknisi_id" class="col-lg-4 col-md-5 col-form-label">Penanggungjawab Teknisi</label>
								<div class="col-lg-8 col-md-7">
									<div id="teknisi_id" data-id="null" class="custom-select" data-toggle="modal" data-target="#modal-teknisi" role="button">Pilih</div>
									<div class="invalid-feedback" id="teknisi_id-feedback"></div>
								</div>
							</div>
							<div class="form-group row">
								<label for="kegunaan" class="col-lg-4 col-md-5 col-form-label">Kegunaan</label>
								<div class="col-lg-8 col-md-7">
									<select id="kegunaan" class="custom-select" role="button">
										<option disabled selected>Pilih</option>
									</select>
									<div class="invalid-feedback" id="kegunaan-feedback"></div>
								</div>
							</div>
						</div>
						<div class="form-group row form-file hide">
							<label for="front" class="col-lg-4 col-md-5 col-form-label">Foto Depan</label>
							<div class="col-lg-8 col-md-7" id="front">
								<div class="file-group file-front">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="front_picture" data-picture="front" role="button" accept=".png, .jpg, .jpeg">
										<label class="custom-file-label">Pilih Foto Depan</label>
										<div id="front_picture-feedback" class="invalid-feedback"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row form-file hide">
							<label for="back" class="col-lg-4 col-md-5 col-form-label">Foto Belakang</label>
							<div class="col-lg-8 col-md-7" id="back">
								<div class="file-group file-back">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="back_picture" data-picture="back" role="button" accept=".png, .jpg, .jpeg">
										<label class="custom-file-label">Pilih Foto Belakang</label>
										<div id="back_picture-feedback" class="invalid-feedback"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="offset-lg-4 offset-md-5 col-lg-8 col-md-7">
								<button class="btn btn-block btn-primary mt-3" id="submit">
									<div class="loader loader-sm none" id="load">
										<svg class="circular" viewBox="25 25 50 50">
											<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="6" stroke-miterlimit="1"/>
										</svg>
									</div>
									<span id="text">Tambah Alker/Salker</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex flex-column justify-content-center align-items-center state" id="loading">
		<div class="loader">
			<svg class="circular" viewBox="25 25 50 50">
				<circle class="path-primary" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"/>
			</svg>
		</div>
	</div>
	<div class="modal fade" id="modal-alker" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-bottom-0">
					<h6 class="modal-title text-capitalize">Cari Alker/Salker</h6>
					<div role="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal">
						<i class="mdi mdi-close mdi-18px pr-0"></i>
					</div>
				</div>
				<div class="modal-body py-0">
					<div class="form-group">
						<input class="form-control" id="search-alker" placeholder="Cari..." autocomplete="off">
					</div>
					<div id="alker" class="overflow-auto hide" style="height:235px"></div>
					<div class="d-flex flex-column justify-content-center align-items-center" id="state-alker" style="height:235px">
						<i class="mdi mdi-magnify mdi-48px"></i>
						<h5>Cari Alker/Salker</h5>
						<p class="text-secondary">Masukkan kode alker/salker.</p>
					</div>
					<div class="d-flex flex-column justify-content-center align-items-center hide" id="empty-alker" style="height:235px">
						<i class="mdi mdi-close-circle mdi-48px"></i>
						<h5>Alker/Salker tidak ditemukan</h5>
						<p class="text-secondary">Masukkan kode alker/salker dengan benar.</p>
					</div>
					<div class="d-flex flex-column justify-content-center align-items-center hide" id="loading-alker" style="height:235px">
						<div class="loader">
							<svg class="circular" viewBox="25 25 50 50">
								<circle class="pathp" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"/>
							</svg>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-link px-4" data-dismiss="modal" data-toggle="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-teknisi" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header border-bottom-0">
					<h6 class="modal-title text-capitalize">Cari Teknisi</h6>
					<div role="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal">
						<i class="mdi mdi-close mdi-18px pr-0"></i>
					</div>
				</div>
				<div class="modal-body py-0">
					<div class="form-group">
						<input class="form-control" id="search-teknisi" placeholder="Cari..." autocomplete="off">
					</div>
					<div id="teknisi" class="overflow-auto hide" style="height:235px"></div>
					<div class="d-flex flex-column justify-content-center align-items-center" id="state-teknisi" style="height:235px">
						<i class="mdi mdi-magnify mdi-48px"></i>
						<h5>Cari Teknisi</h5>
						<p class="text-secondary">Masukkan nama teknisi.</p>
					</div>
					<div class="d-flex flex-column justify-content-center align-items-center hide" id="empty-teknisi" style="height:235px">
						<i class="mdi mdi-close-circle mdi-48px"></i>
						<h5>Teknisi tidak ditemukan</h5>
						<p class="text-secondary">Masukkan nama teknisi dengan benar.</p>
					</div>
					<div class="d-flex flex-column justify-content-center align-items-center hide" id="loading-teknisi" style="height:235px">
						<div class="loader">
							<svg class="circular" viewBox="25 25 50 50">
								<circle class="pathp" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"/>
							</svg>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-link px-4" data-dismiss="modal" data-toggle="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script src="{{asset('api/alker/add-alker.js')}}"></script>
	<script src="{{asset('api/alker/add-teknisi.js')}}"></script>
	<script src="{{asset('api/alker/add-file.js')}}"></script>
	<script src="{{asset('api/create-alker.js')}}"></script>
@endsection