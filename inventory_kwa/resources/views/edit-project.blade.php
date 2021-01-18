@extends('layouts/app')

@section('title','Edit Project')

@section('content')
	<div class="container">
		<h5 class="mb-3">Edit Project</h5>
		<form id="form" enctype="multipart/form-data" class="hide">
			<div class="form-group row">
				<label for="project_name" class="col-xl-3 col-lg-4 col-md-5 col-form-label">Nama Site/Project</label>
				<div class="col-xl-5 col-lg-6 col-md-7">
					<input class="form-control" id="project_name" autofocus="autofocus">
					<div class="invalid-feedback" id="project_name-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<label for="provinsi_id" class="col-xl-3 col-lg-4 col-md-5 col-form-label">Provinsi</label>
				<div class="col-xl-5 col-lg-6 col-md-7">
					<select class="custom-select" id="provinsi_id" role="button">
						<option disabled selected>Pilih</option>
					</select>
					<div class="invalid-feedback" id="provinsi_id-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<label for="kab_kota_id" class="col-xl-3 col-lg-4 col-md-5 col-form-label">Kab/Kota</label>
				<div class="col-xl-5 col-lg-6 col-md-7">
					<select class="custom-select" id="kab_kota_id" role="button">
						<option disabled selected>Pilih</option>
					</select>
					<div class="invalid-feedback" id="kab_kota_id-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<label for="kecamatan" class="col-xl-3 col-lg-4 col-md-5 col-form-label">Kecamatan</label>
				<div class="col-xl-5 col-lg-6 col-md-7">
					<input class="form-control" id="kecamatan">
					<div class="invalid-feedback" id="kecamatan-feedback"></div>
				</div>
			</div>
			<div class="form-group row">
				<div class="offset-xl-3 offset-lg-4 offset-md-5 offset-5 col-xl-3 col-md-4 col-7">
					<div class="d-flex align-items-center">
						<label for="filter" class="text-secondary pt-2 pr-2">Filter</label>
						<select class="custom-select custom-select-sm" id="filter" role="button">
							<option value="all">Semua Kategori</option>
							<option value="horizontal">Horizontal</option>
							<option value="vertical">Vertikal</option>
						</select>
					</div>
				</div>
			</div>
			<div id="data-u"></div>
			<div id="data-n"></div>
			<div class="form-group row">
				<div class="file-group mb-3 offset-xl-3 offset-lg-4 offset-md-5 col-xl-5 col-lg-6 col-md-7">
					<div class="btn btn-md btn-block btn-outline-primary position-relative mt-5" id="add-item">
						<i class="position-absolute mdi mdi-plus mdi-18px" style="left:10px;top:5px"></i>Tambah Material
					</div>
				</div>
			</div>
			<div class="form-group row mb-sm-5">
				<div class="offset-xl-3 offset-lg-4 offset-md-5 col-xl-5 col-lg-6 col-md-7">
					<button class="btn btn-primary btn-block" id="submit">
						<div class="loader loader-sm none" id="load">
							<svg class="circular" viewBox="25 25 50 50">
								<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="6" stroke-miterlimit="1"/>
							</svg>
						</div>
						<span id="text">Simpan Project</span>
					</button>
				</div>
			</div>
		</form>
		<div class="d-flex flex-column justify-content-center align-items-center state" id="loading">
			<div class="loader">
				<svg class="circular" viewBox="25 25 50 50">
					<circle class="pathp" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"/>
				</svg>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script>const id = '{{Request::route("id")}}'</script>
	<script src="{{asset('api/project/edit-item.js')}}"></script>
	<script src="{{asset('api/edit-project.js')}}"></script>
@endsection