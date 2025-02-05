<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <title>ADD NEW CUSTOMER</title>
</head>

<body>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
        data-bs-whatever="@mdo">ADD NEW CUSTOMER</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="SubmitForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="customername" class="col-form-label">Customer Name:</label>
                            <input name="customername" type="text" class="form-control" id="customername">
                        </div>
                        <div class="mb-3">
                            <label for="customerage" class="col-form-label">Customer Age:</label>
                            <input name="customerage" type="number" class="form-control" id="customerage">
                        </div>
                        <div class="mb-3">
                            <label for="customerbmi" class="col-form-label">Customer BMI:</label>
                            <input name="customerbmi" type="number" step="0.01" class="form-control" id="customerbmi">
                        </div>
                        <div class="mb-3">
                            <label for="customercode" class="col-form-label">Customer Code:</label>
                            <input name="customercode" type="password" class="form-control" id="customercode">
                        </div>
                        <div class="mb-3">
                            <label for="customerdate" class="col-form-label">Customer Date:</label>
                            <input name="customerdate" type="date" class="form-control" id="customerdate">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="col-form-label">Gender:</label>
                            <input type="radio" name="gender" value="male"> Male
                            <input type="radio" name="gender" value="female"> Female
                        </div>
                        <div class="mb-3">
                            <label for="membership" class="col-form-label">Membership:</label>
                            <select name="membership" class="form-control">
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="profilepic" class="col-form-label">Profile Picture:</label>
                            <input name="profilepic" type="file" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="permission" class="col-form-label">Permission:</label>
                            <input name="permission" type="checkbox" value="allowed">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table" id="datatable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Customer Age</th>
                <th scope="col">BMI</th>
                <th scope="col">Customer Code</th>
                <th scope="col">Customer Date</th>
                <th scope="col">Gender</th>
                <th scope="col">Membership</th>
                <th scope="col">File</th>
                <th scope="col">Permission</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here -->
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchrecord();

            $('#SubmitForm').on('submit', function (e) {
                e.preventDefault();
                var id = $('#id').val();
                var formData = new FormData(this);
                var url = id ? `/customerupdate/${id}` : "{{ route('customerstore') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#SubmitForm')[0].reset();
                        $('#exampleModal').modal('hide');
                        alert(response.success);
                        fetchrecord();
                    }
                });
            });

            function fetchrecord() {
                $.ajax({
                    url: "{{ route('customerget') }}",
                    type: "GET",
                    success: function (response) {
                        var tr = '';
                        for (var i = 0; i < response.length; i++) {
                            var id = response[i].id;
                            var customername = response[i].customername;
                            var customerage = response[i].customerage;
                            var customerbmi = response[i].customerbmi;
                            var customercode = response[i].customercode;
                            var date = response[i].customerdate;
                            var gender = response[i].gender;
                            var profilepic = response[i].profilepic;
                            var permission = response[i].permission;
                            var membership = response[i].membership;

                            tr += '<tr>';
                            tr += '<td>' + id + '</td>';
                            tr += '<td>' + customername + '</td>';
                            tr += '<td>' + customerage + '</td>';
                            tr += '<td>' + customerbmi + '</td>';
                            tr += '<td>' + customercode + '</td>';
                            tr += '<td>' + date + '</td>';
                            tr += '<td>' + gender + '</td>';
                            tr += '<td>' + membership + '</td>';
                            tr += '<td>' + profilepic + '</td>';
                            tr += '<td>' + permission + '</td>';
                            tr += `<td><button class="btn btn-success editBtn" data-id="${id}">Edit</button>  <button class="btn btn-danger deleteBtn" data-id="${id}">Delete</button></td>`;
                            tr += '</tr>';
                        }
                        $('#datatable tbody').html(tr);
                    }
                });
            }

            $(document).on('click', '.editBtn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: `/customeredit/${id}`,
                    type: "GET",
                    success: function (response) {
                        $('#id').val(response.id);
                        $('#customername').val(response.customername);
                        $('#customerage').val(response.customerage);
                        $('#customerbmi').val(response.customerbmi);
                        $('#customercode').val(response.customercode);
                        $('#customerdate').val(response.customerdate);
                        $('input[name="gender"][value="' + response.gender + '"]').prop('checked', true);
                        $('select[name="membership"]').val(response.membership);
                        $('input[name="permission"]').prop('checked', response.permission === 'allowed');
                        $('#exampleModal').modal('show');
                    }
                });
            });


            $(document).on('click', '.deleteBtn', function () {
                var id = $(this).data('id');

                $.ajax({
                    url: `/customerdelete/${id}`,
                    type: "delete",  // Using POST method
                    data: {  // Simulate DELETE request
                        _token: "{{ csrf_token() }}"  // Directly insert CSRF token
                    },
                    success: function (response) {
                        alert('Customer Deleted');
                        fetchrecord();  // Refresh the records
                    },
                    error: function () {
                        alert('Delete operation failed!');
                    }
                });
            });

        });
    </script>
</body>

</html>