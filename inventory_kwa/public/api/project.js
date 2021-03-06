get_project()

function get_project(page) {
    $.ajax({
        url: api_url + 'project/get',
        type: 'GET',
        data: {
            page: page
        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            // console.log(result.data)
            $('#table').html('')
            $('#loading').addClass('hide')
            $('#table-empty').addClass('hide')
            $('#table-loading').addClass('hide')
            if (result.data.length > 0) {
                $('#data').removeClass('hide')
                let append, nama_barang, quantity, category, stok, status, danger, success, del, sta = []
                let from = result.meta.from
                $.each(result.data, function(index, value) {
                    sta = []
                    kode_barang = ''
                    nama_barang = ''
                    quantity = ''
                    category = ''
                    status = ''
                    stok = ''
                    $.each(value.project_items, function(index, value) {
                        value.item.stock < 5 ? danger = 'text-danger' : danger = ''
                        value.status == 'accepted' ? success = 'text-success' : success = 'text-warning'
                        kode_barang += '<li class="text-truncate">' + value.item.kode + '</li>'
                        nama_barang += '<li class="text-truncate">' + value.item.nama_barang + '</li>'
                        quantity += '<span class="d-block text-truncate">' + value.quantity + ' ' + value.item.satuan + '</span>'
                        value.category == 'horizontal' ? category += '<span class="d-block text-truncate">Horizontal</span>' : category += '<span class="d-block text-truncate">Vertikal</span>'
                        if (value.status == 'pending') {
	                        stok += '<span class="d-block text-truncate ' + danger + '">' + value.item.stock + ' ' + value.item.satuan + '</span>'
	                    } else {
	                        stok += '<span class="d-block text-truncate">&nbsp;</span>'
	                    }
                        status += '<span class="d-block text-truncate ' + success + '">' + value.status + '</span>'
                        sta.push(value.status)
                    })
                    if (sta.includes('accepted')) {
                        del = ''
                    } else {
                    	if (level == 102) {
	                        del = '<i class="mdi mdi-trash mdi-trash-can-outline mdi-18px pr-0" role="button" data-toggle="modal" data-target="#modal-delete"></i>'
                    	}
                    }
                    append = `<tr data-id="${value.id}" data-project="${value.project_name}">
						<td class="text-center">${from}.</td>
						<td><a href="${root}project/${value.id}">${value.project_name}</a></td>
						<td>${nama_barang}</td>
						<td>${quantity}</td>
						<td>${category}</td>
						<td>${stok}</td>
						<td class="text-capitalize">${status}</td>
						<td>${del}</td>
					</tr>`
                    $('#table').append(append)
                    from++
                })
                pagination(result.links, result.meta, result.meta.path)
            } else {
                $('#empty').removeClass('hide')
            }
        },
        error: function(xhr, status) {
            setTimeout(function() {
                get_project(page)
            }, 1000)
        }
    })
}

let totalDelete = []
$(document).on('click', '.mdi-trash', function() {
    let id = $(this).closest('tr').data('id')
    let project = $(this).closest('tr').data('project')
    totalDelete = []
    totalDelete.push(id)
    $('#btn-delete').data('id', id)
    $('.modal-body').html('Anda yakin ingin menghapus project <b>' + project + '</b>?')
})

// $(document).on('click','.mdi-trash-all',function(){
// 	let id = ''
// 	totalDelete = []
// 	$('.mdi-check.mdi-checkbox-marked').each(function(index, value){
// 		id = atob($(value).closest('tr').data('id')).split(',')
// 		totalDelete.push(id[1])
// 	})
// 	$('.modal-body').html('Anda yakin ingin menghapus '+href+' yang dipilih?')
// })

$('#delete').click(function() {
    del(totalDelete)
    $('#data').addClass('hide')
    $('#loading').removeClass('hide')
    $('#modal-delete').modal('hide')
})

function del(idDelete) {
    let length = totalDelete.length
    $.each(idDelete, function(index, value) {
        $.ajax({
            url: api_url + 'project/delete/' + value,
            type: 'DELETE',
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token)
            },
            success: function(result) {
                get_project()
                $('#search').val('')
            }
        })
    })
}

let formData = new FormData()
$('#search').keyup(function(e) {
    let param = $(this).val()
    let keyCode = e.originalEvent.keyCode
    if (keyCode >= 48 && keyCode <= 90 || keyCode == 8) {
    	$('#table').html('')
        $('#data').addClass('hide')
    	$('#loading').removeClass('hide')
        $('#table-empty').addClass('hide')
        $('#pagination').addClass('hide')
        param.length != 0 ? $('#search-close').removeClass('hide') : $('#search-close').addClass('hide')
    }
})
$('#search').keyup(delay(function(e) {
    let param = $(this).val()
    let keyCode = e.originalEvent.keyCode
    if (keyCode >= 48 && keyCode <= 90 || keyCode == 8) {
        param.length != 0 ? search_project(param) : get_project()
    }
}, 500))
$('#search-close').click(function() {
    $('#search').val('')
    $(this).addClass('hide')
    get_project()
})

function search_project(param) {
    formData.delete('search')
    formData.append('search', param)
    $.ajax({
        url: api_url + 'project/search',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token)
        },
        success: function(result) {
            $('#table').html('')
            $('#loading').addClass('hide')
            $('#table-loading').addClass('hide')
            if (result.data.length > 0) {
                $('#data').removeClass('hide')
                let append, nama_barang, quantity, category, stok, status, danger, success, del, sta = []
                let from = 1
                $.each(result.data, function(index, value) {
                    sta = []
                    kode_barang = ''
                    nama_barang = ''
                    quantity = ''
                    category = ''
                    status = ''
                    stok = ''
                    $.each(value.project_items, function(index, value) {
                        value.item.stock < 5 ? danger = 'text-danger' : danger = ''
                        value.status == 'accepted' ? success = 'text-success' : success = 'text-warning'
                        kode_barang += '<li class="text-truncate">' + value.item.kode + '</li>'
                        nama_barang += '<li class="text-truncate">' + value.item.nama_barang + '</li>'
                        quantity += '<span class="d-block text-truncate">' + value.quantity + ' ' + value.item.satuan + '</span>'
                        value.category == 'horizontal' ? category += '<span class="d-block text-truncate">Horizontal</span>' : category += '<span class="d-block text-truncate">Vertikal</span>'
                        if (value.status == 'pending') {
	                        stok += '<span class="d-block text-truncate ' + danger + '">' + value.item.stock + ' ' + value.item.satuan + '</span>'
	                    } else {
	                        stok += '<span class="d-block text-truncate">&nbsp;</span>'
	                    }
                        status += '<span class="d-block text-truncate ' + success + '">' + value.status + '</span>'
                        sta.push(value.status)
                    })
                    if (sta.includes('accepted')) {
                        del = ''
                    } else {
                    	if (level == 102) {
	                        del = '<i class="mdi mdi-trash mdi-trash-can-outline mdi-18px pr-0" role="button" data-toggle="modal" data-target="#modal-delete"></i>'
	                    }
                    }
                    append =
                        `<tr data-id="${value.id}" data-project="${value.project_name}">
						<td class="text-center">${from}.</td>
						<td><a href="${root}project/${value.id}">${value.project_name}</a></td>
						<td>${nama_barang}</td>
						<td>${quantity}</td>
						<td>${category}</td>
						<td>${stok}</td>
						<td class="text-capitalize">${status}</td>
						<td>${del}</td>
					</tr>`
                    $('#table').append(append)
                    from++
                })
            } else {
                $('#table-empty').removeClass('hide')
            }
        },
        error: function(xhr, status) {
            setTimeout(function() {
                search_project(param)
            }, 1000)
        }
    })
}

$('.page').click(function() {
    if (!$(this).is('.active, .disabled')) {
        let page = $(this).data('id')
        $('#table').html('')
        $('#pagination').addClass('hide')
        $('#table-loading').removeClass('hide')
        get_project(page)
    }
})
