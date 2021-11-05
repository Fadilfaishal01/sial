@extends('layouts.app')

@section('main-content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-list"></i> {{ $title }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ $title }}</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-bordered table-striped" id="table" width="100%">
                        <thead class="text-center bg-primary text-white">
                            <th width="8%">#</th>
                            <th>Name</th>
                            <th>Brand</th>    
                            <th>Type</th>    
                            <th>Price</th>    
                            <th>Description</th>
                            <th width="20%">
                                <button class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#modalLevis" onclick="addData()"><i class="fa fa-plus-circle"></i> Add Type</button>
                            </th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalLevis" tabindex="-1" role="dialog" aria-labelledby="modalLevisLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-list"></i> &nbsp; <span id="modalTitle"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <input type="hidden" id="idLevis">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="type font-weight-bold" for="type">Levis Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-list"></i></span></div>
                                    <input class="form-control" id="levis" type="text" placeholder="Input Levis Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="font-weight-bold">Brand</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tags"></i></span></div>
                                    <select class="form-control" id="brandSelect" style="width: 94.6%;">
                                    
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="font-weight-bold">Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-cube"></i></span></div>
                                    <select class="form-control" id="typeSelect" style="width: 94.6%;">
                                    
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="type font-weight-bold" for="type">Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tags"></i></span></div>
                                    <input class="form-control" id="price" type="number" placeholder="Input Price">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="type font-weight-bold" for="type">Description</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-file"></i></span></div>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Input Description"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnClose"><i class="fa fa-times"></i> Close</button>
                    <button type="button" class="btn btn-info" id="btnSave"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-info" id="btnUpdate"><i class="fa fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-native')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        const table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: "{{ route('admin.levis.apiData') }}",
                type: "GET"
            },
            columns: [
                {data: null},
                {data: 'lName', name:'lName', orderable: true, searchable: true, defaultContent: ''},
                {data: 'brand.bName', name:'brand.bName', orderable: true, searchable: true, defaultContent: ''},
                {data: 'type.tName', name:'type.tName', orderable: true, searchable: true, defaultContent: ''},
                {data: 'Price', name:'Price', orderable: true, searchable: true, defaultContent: ''},
                {data: 'lDescription', name:'lDescription', orderable: true, searchable: true, defaultContent: ''},
                {data: 'action', name:'action', orderable: true, searchable: true, defaultContent: ''},
            ],
            columnDefs: [
                {targets: 0, searchable: false, orderable: false},
            ],
        });

        table.on('draw.dt', function () {
            var PageInfo = $("#table").DataTable().page.info();

            table.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1 + PageInfo.start;
            });
        })

        $(document).ready(function() {

            $('#btnClose').click(function() {
                $('#levis').val('');
                $('#brandSelect').html('');
                $('#typeSelect').html('');
                $('#price').val('');
                $('#description').val('');
            });

            $('#btnSave').click(function() {
                $.ajax({
                    type:'POST',
                    url: "{{ route('admin.levis.save') }}",
                    data: {
                        _token: CSRF_TOKEN,
                        levis: $('#levis').val(),
                        brand: $('#brandSelect').val(),
                        type: $('#typeSelect').val(),
                        price: $('#price').val(),
                        description: $('#description').val(),
                    },
                    success: function(data) {
                        swal({
                            text: `${data.message}`,
                            title: `${data.title}`,
                            icon: `${data.status}`,
                            timer: `${data.timer}`,
                            closeOnClickOutside: false,
                        });

                        $('#modalLevis').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(data) {
                        swal({
                            text: `${data.message}`,
                            title: `${data.title}`,
                            icon: `${data.status}`,
                            timer: `${data.timer}`,
                            closeOnClickOutside: false,
                        });

                        $('#modalLevis').modal('hide');
                        table.ajax.reload();
                    }
                })
            });

            $('#btnUpdate').click(function() {
                $.ajax({
                    type:'POST',
                    url: "{{ route('admin.levis.update') }}",
                    data: {
                        _token: CSRF_TOKEN,
                        id: $('#idLevis').val(),
                        levis: $('#levis').val(),
                        brand: $('#brandSelect').val(),
                        type: $('#typeSelect').val(),
                        price: $('#price').val(),
                        description: $('#description').val(),
                    },
                    success: function(data) {
                        swal({
                            text: `${data.message}`,
                            title: `${data.title}`,
                            icon: `${data.status}`,
                            timer: `${data.timer}`,
                            closeOnClickOutside: false,
                        });

                        $('#modalLevis').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(data) {
                        swal({
                            text: `${data.message}`,
                            title: `${data.title}`,
                            icon: `${data.status}`,
                            timer: `${data.timer}`,
                            closeOnClickOutside: false,
                        });

                        $('#modalLevis').modal('hide');
                        table.ajax.reload();
                    }
                })
            });

        });

        function addData() {
            $('#modalLevis').modal({backdrop: 'static', keyboard: false});
            $('#modalTitle').text('Add Levis');
            $('#levis').val('').attr('readonly', false);
            $('#brandSelect').html('').attr('disabled', false).change();
            $('#typeSelect').html('').attr('disabled', false).change();
            $('#price').val('').attr('readonly', false);
            $('#description').val('').attr('readonly', false);
            $('#btnSave').show();
            $('#btnUpdate').hide();
        }

        function detailData(id) {
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.levis.edit') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#idType').val(data.lId);
                    $('#modalLevis').modal({backdrop: 'static', keyboard: false});
                    $('#modalTitle').text('Detail Levis ' + data.lName);
                    $('#levis').val(data.lName).attr('readonly', true);
                    $('#brandSelect').append($('<option>').val(data.brand.bName).text(data.brand.bName)).attr('disabled', true).change();
                    $('#typeSelect').append($('<option>').val(data.type.tName).text(data.type.tName)).attr('disabled', true).change();
                    $('#price').val(data.lPrice).attr('readonly', true);
                    $('#description').val(data.lDescription).attr('readonly', true);
                    $('#btnSave').hide();
                    $('#btnUpdate').hide();
                },
                error: function(data) {

                }
            })
        }

        function editData(id) {
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.levis.edit') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#idLevis').val(data.lId);
                    $('#modalLevis').modal({backdrop: 'static', keyboard: false});
                    $('#modalTitle').text('Detail Levis ' + data.lName);
                    $('#levis').val(data.lName).attr('readonly', false);
                    $('#brandSelect').append($('<option>').val(data.brand.bName).text(data.brand.bName)).attr('disabled', false).change();
                    $('#typeSelect').append($('<option>').val(data.type.tName).text(data.type.tName)).attr('disabled', false).change();
                    $('#price').val(data.lPrice).attr('readonly', false);
                    $('#description').val(data.lDescription).attr('readonly', false);
                    $('#btnSave').hide();
                    $('#btnUpdate').show();
                },
                error: function(data) {

                }
            })
        }

        function deleteData(id) {
            swal({
                title: 'Are you sure?',
                text: "you want delete this data",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, i sure!'
            },function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.levis.delete') }}",
                        data: {
                            _token: CSRF_TOKEN,
                            id : id
                        },
                        success: function(data) {
                            swal({
                                text: `${data.message}`,
                                title: `${data.title}`,
                                icon: `${data.status}`,
                                timer: `${data.timer}`,
                                closeOnClickOutside: false,
                            });

                            table.ajax.reload();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    })
                }
            });
        }

        $('#brandSelect').select2({
            ajax: {
                url: "{{ route('admin.levis.getBrand') }}",
                type: "GET",
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            placeholder: 'Select Brand',
            allowClear: false
        });

        $('#typeSelect').select2({
            ajax: {
                url: "{{ route('admin.levis.getType') }}",
                type: "GET",
                dataType: 'json',
                delay: 100,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            placeholder: 'Select Type',
            allowClear: false
        });
    </script>
@endsection