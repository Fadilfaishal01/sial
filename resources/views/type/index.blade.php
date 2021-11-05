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
                            <th>Type</th>
                            <th>Description</th>
                            <th width="20%">
                                <button class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#modalType" onclick="addData()"><i class="fa fa-plus-circle"></i> Add Type</button>
                            </th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalType" tabindex="-1" role="dialog" aria-labelledby="modalTypeLabel" aria-hidden="true">
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
                        <input type="hidden" id="idType">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="type font-weight-bold" for="type">Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-list"></i></span></div>
                                    <input class="form-control" id="type" type="text" placeholder="Input Type">
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
                url: "{{ route('admin.type.apiData') }}",
                type: "GET"
            },
            columns: [
                {data: null},
                {data: 'tName', name:'tName', orderable: true, searchable: true, defaultContent: ''},
                {data: 'tDescription', name:'tDescription', orderable: true, searchable: true, defaultContent: ''},
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
                $('#type').val('');
                $('#description').val('');
            });

            $('#btnSave').click(function() {
                $.ajax({
                    type:'POST',
                    url: "{{ route('admin.type.save') }}",
                    data: {
                        _token: CSRF_TOKEN,
                        type: $('#type').val(),
                        description: $('#description').val(),
                    },
                    success: function(data) {
                        swal({
                            content: {
                                element: "div",
                                attributes: {
                                    text: `${data.message}`
                                }
                            },
                            title: `${data.title}`,
                            icon: `${data.status}`,
                            timer: `${data.timer}`,
                            closeOnClickOutside: false,
                        });

                        $('#modalType').modal('hide');
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

                        $('#modalType').modal('hide');
                        table.ajax.reload();
                    }
                })
            });

            $('#btnUpdate').click(function() {
                $.ajax({
                    type:'POST',
                    url: "{{ route('admin.type.update') }}",
                    data: {
                        _token: CSRF_TOKEN,
                        id: $('#idType').val(),
                        type: $('#type').val(),
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

                        $('#modalType').modal('hide');
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

                        $('#modalType').modal('hide');
                        table.ajax.reload();
                    }
                })
            });

        });

        function addData() {
            $('#modalType').modal({backdrop: 'static', keyboard: false});
            $('#modalTitle').text('Add Type');
            $('#type').val('').attr('readonly', false);
            $('#description').val('').attr('readonly', false);
            $('#btnSave').show();
            $('#btnUpdate').hide();
        }

        function detailData(id) {
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.type.edit') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#idType').val(data.tId);
                    $('#modalType').modal({backdrop: 'static', keyboard: false});
                    $('#modalTitle').text('Detail Type ' + data.tName);
                    $('#type').val(data.tName).attr('readonly', true);
                    $('#description').val(data.tDescription).attr('readonly', true);
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
                url: "{{ route('admin.type.edit') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#idType').val(data.tId);
                    $('#modalType').modal({backdrop: 'static', keyboard: false});
                    $('#modalTitle').text('Detail Type ' + data.tName);
                    $('#type').val(data.tName).attr('readonly', false);
                    $('#description').val(data.tDescription).attr('readonly', false);
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
                        url: "{{ route('admin.type.delete') }}",
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
    </script>
@endsection