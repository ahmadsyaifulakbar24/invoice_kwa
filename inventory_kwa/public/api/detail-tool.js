let total = 0

process()

function process() {
    $.ajax({
        url: api_url + 'alker/get_by_code',
        type: 'GET',
        data: {
            kode_alker: atob(kode_alker)
        },
        timeout: 5000,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            let value = result.data
            // console.log(value)

            $('#kode_alker').data('id', value.id)
            $('#kode_main_alker').html(value.main_alker.kode_main_alker)
            $('#nama_barang').html(value.main_alker.nama_barang)
            $('#satuan').html(value.main_alker.satuan)

            $('#kode_alker').html(value.kode_alker)
            $('#sto').html(value.sto.sto)
            $('#teknisi').html(value.teknisi.name)
            $('#kegunaan').html(value.kegunaan)

            let status
            value.status == 'in' || value.status == 'pending' ? status = 'Di Gudang' : status = 'Sudah Keluar'
            $('#status').html(status)

            $('.keterangan').html(value.keterangan)
            $('#edit').attr('href', root + 'tool/edit/' + value.id)

            value.front_picture == '' || value.front_picture == null ? $('#front').hide() : ''
            value.back_picture == '' || value.back_picture == null ? $('#back').hide() : ''
            $('#front_picture').attr('href', value.front_picture)
            $('#back_picture').attr('href', value.back_picture)

            $('#qrcode').append(`<div id="qrcode${value.id}"></div>`)
            createCode(value.id, value.kode_alker)
        },
        error: function(xhr, status) {
            setTimeout(function() {
                process()
            }, 1000)
        }
    })
}

function history() {
    $('#history').html('')
    let id = $('#kode_alker').data('id')
    $.ajax({
        url: api_url + 'alker/get_alker_history/' + id,
        type: 'GET',
        timeout: 5000,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            let value = result.data
            // console.log(value)
            let log, link
            let append = '',
                appendModal = ''
            $.each(value, function(index, value) {
                let border = (index != 0) ? 'border-right' : ''
                link = ''
                switch (value.status) {
                    case 'create_goods':
                        log = 'Tambah Alker'
                        break
                    case 'request_goods':
                        log = 'Request Alker'
                        break
                    case 'exit_goods':
                        log = 'Alker disetujui'
                        link = `<a href="` + root + `alker/${value.alker_request.id}" target="_blank">Lihat detail</a>`
                        break
                    case 'not_good_goods':
                        log = 'Barang keluar'
                        break
                    case 'incoming_goods':
                        log = 'Barang masuk'
                        link = `<a href="` + root + `alker/${value.alker_request.id}" target="_blank">Lihat detail</a>`
                        break
                    case 'update_goods':
                        log = 'Mengubah keterangan'
                }
                append =
                    `<div class="row">
		            <div class="col-auto text-center flex-column d-sm-flex px-1">
		                <div class="m-2">
		                    <i class="mdi mdi-checkbox-blank-circle mdi-18px pr-0" style="color:#dee2e6"></i>
		                </div>
		                <div class="row" style="height:45px;margin:-15px">
		                    <div class="col ` + border + `">&nbsp;</div>
		                    <div class="col">&nbsp;</div>
		                </div>
		            </div>
		            <div class="col col-xl-10 pl-0" style="padding-top:11px">
		            	<div class="d-flex flex-column align-items-start">
		                	<small class="text-secondary">` + value.created_at + `</small>
		                	<small>` + log + `. ` + link + `</small>
		                </div>
		            </div>
		        </div>`
                $('#history').prepend(append)
            })
            $('#data').removeClass('hide')
            $('#loading').addClass('hide')
            total++
        },
        error: function(xhr, status) {
            setTimeout(function() {
                history()
            }, 1000)
        }
    })
}

$(document).ajaxStop(function() {
    total < 1 ? history() : ''
})

$('#modal-keterangan').on('shown.bs.modal', function(e) {
    $('#keterangan').focus()
})

$('#edit').submit(function(e) {
    e.preventDefault()
    $('#btn-edit').attr('disabled', true)
    let id = $('#kode_alker').data('id')
    let keterangan = $('#keterangan').val()
    $.ajax({
        url: api_url + 'alker/update/' + id,
        type: 'PATCH',
        data: {
            keterangan: keterangan
        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            $('.keterangan').html(result.data.keterangan)
            $('#btn-edit').attr('disabled', false)
            $('#modal-keterangan').modal('hide')
            history()
        },
        error: function(xhr) {
            removeLoading()
            let err = JSON.parse(xhr.responseText)
            // console.log(err)
        }
    })
})
