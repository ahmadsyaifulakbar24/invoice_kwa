let item = []
let total = 0

api_provinsi()

function api_provinsi() {
    $.ajax({
        url: api_url + 'provinsi',
        type: 'GET',
        timeout: 5000,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            let append
            $.each(result.data, function(index, value) {
                append = `<option value=${value.id}>${value.provinsi}</option>`
                $('#provinsi_id').append(append)
            })
        },
        error: function(xhr, status) {
            setTimeout(function() {
                api_provinsi()
            }, 1000)
        }
    })
}

function api_kab_kota(provinsi_id) {
    $.ajax({
        url: api_url + 'kab_kota/' + provinsi_id,
        type: 'GET',
        timeout: 5000,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            let append
            $.each(result.data, function(index, value) {
                append = `<option value=${value.id}>${value.kab_kota}</option>`
                $('#kab_kota_id').append(append)
            })
        },
        error: function(xhr, status) {
            setTimeout(function() {
                api_kab_kota(provinsi_id)
            }, 1000)
        }
    })
}

function api_item() {
    $.ajax({
        url: api_url + 'item/get',
        type: 'GET',
        timeout: 5000,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            $.each(result.data, function(index, value) {
                item[index] = {
                    id: value.id,
                    kode: value.kode,
                    nama_barang: value.nama_barang,
                    keterangan: value.keterangan,
                    satuan: value.satuan,
                    jenis: value.jenis,
                    stock: value.stock
                }
            })
            addItem(1, true)
            $('#project').show()
            $('#loading').addClass('hide')
            total++
        },
        error: function(xhr, status) {
            setTimeout(function() {
                api_item()
            }, 1000)
        }
    })
}

$(document).ajaxStop(function() {
    total < 1 ? api_item() : ''
})

$('#add-item').click(function() {
    let length = $('.form-item').length + 1
    addItem(length)
})

let provinsi_id
$('#provinsi_id').change(function() {
    provinsi_id = $(this).val()
    $('#kab_kota_id').html('<option disabled selected>Pilih</option>')
    api_kab_kota(provinsi_id)
})

let unit
$(document).on('change', '.item_id', function() {
    unit = $(this).find(':selected').data('unit')
    $(this).parents('.form-group').siblings('.request').find('input').attr('disabled', false)
    $(this).parents('.form-group').siblings('.request').find('input').focus()
    $(this).parents('.form-group').siblings('.request').find('input').val('')
    $(this).parents('.form-group').siblings('.request').find('.input-group-text').html(unit)
})

$(document).on('click', '.close', function() {
	if ($('.form-item').length > 1) {
	    $(this).parents('.form-item').slideUp('fast', function() {
	        $(this).remove()
		    $('.number').each(function(i, o) {
		        $(this).html((i + 1) + ')')
		    })
		    $('.item_id').each(function(i, o) {
		        $(this).attr('data-id', (i + 1))
		    })
		    $('.quantity').each(function(i, o) {
		        $(this).attr('data-id', (i + 1))
		    })
		    $('.category').each(function(i, o) {
		        $(this).attr('data-id', (i + 1))
		    })
		    let length = $('.form-item').length + 1
		    length == 1 ? addItem(length) : ''
		})
	}
})

function addItem(id) {
    let append, kabel, odp, odc, otb, pipa, tiang
    $.each(item, function(index, value) {
        // console.log(value)
        if (value.jenis == 'Kabel') {
            kabel += `<option value="${value.id}" data-unit="${value.satuan}">${value.nama_barang}</option>`
        }
        else if (value.jenis == 'ODP') {
            odp += `<option value="${value.id}" data-unit="${value.satuan}">${value.nama_barang}</option>`
        }
        else if (value.jenis == 'ODC') {
            odc += `<option value="${value.id}" data-unit="${value.satuan}">${value.nama_barang}</option>`
        }
        else if (value.jenis == 'OTB') {
            otb += `<option value="${value.id}" data-unit="${value.satuan}">${value.nama_barang}</option>`
        }
        else if (value.jenis == 'Pipa') {
            pipa += `<option value="${value.id}" data-unit="${value.satuan}">${value.nama_barang}</option>`
        }
        else if (value.jenis == 'Tiang') {
            tiang += `<option value="${value.id}" data-unit="${value.satuan}">${value.nama_barang}</option>`
        }
    })
    append = `<div class="form-item">
		<div class="form-group row">
			<div class="col-12"><hr></div>
		</div>
        <div class="row">
        	<div class="col-md-4 col-2">
        		<h3 class="number text-center">${id})</h3>
        	</div>
        	<div class="col-md-7 col-9">
				<div class="form-group">
					<label class="form-label">Nama Material</label>
					<div class="close form-close close-item" title="Hapus">
						<i class="mdi mdi-trash-can-outline mdi-18px pr-0"></i>
					</div>
					<select class="custom-select item_id" data-id="${id}" role="button">
						<option disabled selected>Pilih</option>
						<optgroup label="Kabel">${kabel}</optgroup>
						<optgroup label="ODP">${odp}</optgroup>
						<optgroup label="ODC">${odc}</optgroup>
						<optgroup label="OTB">${otb}</optgroup>
						<optgroup label="Pipa">${pipa}</optgroup>
						<optgroup label="Tiang">${tiang}</optgroup>
					</select>
					<div class="invalid-feedback">Pilih nama material.</div>
				</div>
				<div class="form-group request">
					<label class="form-label">Request Material</label>
					<div class="input-group">
						<input type="number" class="form-control quantity" data-id="${id}">
						<div class="input-group-append">
							<span class="input-group-text">Satuan</span>
						</div>
						<div class="invalid-feedback">Masukkan jumlah request material.</div>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">Kategori</label>
					<select class="custom-select category" data-id="${id}" role="button">
						<option disabled selected>Pilih</option>
						<option value="horizontal">Horizontal</option>
						<option value="vertical">Vertikal</option>
					</select>
					<div class="invalid-feedback">Pilih kategori.</div>
				</div>
			</div>
		</div>
	</div>`
    $('#data').append(append)
    if (id != 1) $('#data').find('.form-item').last().hide().slideDown('fast')
}
