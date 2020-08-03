@extends('layouts.app')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
@endpush
@section('content')
<!-- Button trigger modal -->
<button onclick="resetForm()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#newStudent">
    Add Student
</button>
<hr>
<table id="dataTable" class="table table-sm table-hover table-bordered data-table" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Class</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="newStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="formStudent" method="POST" action="">
                    @csrf
                    <div id="message"></div> <!-- Error Massage -->
                    <div class="form-group">
                        <label> Name </label>
                        <input id="name" type="text" name="name" class="form-control" autocomplete="off">
                        <small class="form-text text-danger">{{ $errors->first('name') }}</small>
                    </div>
                    <div class="form-group">
                        <label> Age </label>
                        <input id="age" type="text" name="age" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label> Class </label>
                        <input id="class_id" type="text" name="class_id" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label> Gender </label>
                        <select class="custom-select" id="gender" name="gender">
                            <option value="">No Selected</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Address </label>
                        <textarea resizable="true" id="address" type="text" name="address" class="textarea-autosize form-control" autocomplete="off" rows="3"></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button value="Store" id="action" type="submit" class="btn btn-primary"><i class="feather icon-save mr-2"></i><a id="actionLabel">Save</a></button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js">
</script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js">
</script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js">
</script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            ajax: "{{ route('jsonStudents') }}",
            lengthMenu: [
                [5, 10, 25],
                [5, 10, 25]
            ],
            columnDefs: [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "10%",
                    "targets": 4
                }
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',

                },
                {
                    data: 'class_id',
                    name: 'class_id',

                },
                {
                    data: 'gender',
                    name: 'gender',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#formStudent').on('submit', (function(event) {
            event.preventDefault();
            /* Store */
            if ($('#action').val() == "Store") {

                $.ajax({
                    url: "{{ route('storeStudent') }}",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log('Success:', data);
                        table.draw();
                        alert('Saved Successfully');
                        $('#newStudent').modal('hide');
                        resetForm();
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                        errorsHtml = '<div class="text-danger"><ul>';
                        $.each(errors.errors, function(k, v) {
                            errorsHtml += '<li>' + v + '</li>';
                        });
                        errorsHtml += '</ul></di>';
                        $('#message').html(errorsHtml);
                    }
                });

            }

        }));
        /* End Document Ready */
    });

    function resetForm() {
        document.getElementById("formStudent").reset();
    }
</script>
@endpush
