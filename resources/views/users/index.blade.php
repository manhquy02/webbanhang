<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <title>User</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
</head>

<body class="bg-light">
    <div class="d-flex">
        @include('partials.sidebar')
        <div class="flex-grow-1">
            @include('partials.header',['pageTitle'=>'Người dùng'])
            @if(session('delete_success'))
            <div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1155;">
                <div class="toast show bg-success text-white" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('delete_success') }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            @endif

            @if(session('create_success'))
            <div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1155;">
                <div class="toast show bg-success text-white" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{session('create_success')}}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            @endif

            @if(session('update_success'))
            <div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1155;">
                <div class="toast show bg-success text-white" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{session('update_success')}}

                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            @endif

            <main class="container-fluid">
                <main class="p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{route('users.index')}}" method='get'>
                                <div class="row align-items-center pb-3 border-bottom">
                                    <div class="col-md-4">
                                        <input type="text" name="username" class="search-name form-control" placeholder="Tìm theo tên " value="{{request('username')}}" onchange="this.form.submit()">
                                    </div>
                                    <div class="col-auto  ms-auto">
                                        <a href="{{route('users.export')}}" id="export-file" class="btn btn-secondary me-2">Xuất file</a>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Thêm người dùng</button>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12 table-container">
                                <table class="table table-hover table-striped">
                                    <thead class="bg-body-secondary">
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên người dùng</th>
                                            <th>Email</th>
                                            <th>Quyền</th>
                                            <th class="text-end ">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-list">
                                        @if($users->count()>0)
                                        @foreach($users as $index => $user)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                {{$user->permission_level}}
                                            </td>
                                            <td class="text-end fs-5">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="detail-btn border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal"
                                                        data-username="{{ $user->username }}"
                                                        data-email="{{ $user->email }}"
                                                        data-role="{{ $user->role }}"
                                                        data-permission_level="{{ $user->permission_level }}">
                                                        <i class="bi bi-eye" data-bs-toggle="tooltip" title="Xem"></i>
                                                    </button>
                                                    @can('edit-content')
                                                    <button type="button" class="edit-user border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-id="{{$user->id}}"
                                                        data-username="{{ $user->username }}"
                                                        data-email="{{ $user->email }}"
                                                        data-role="{{ $user->role }}"
                                                        data-permission_level="{{ $user->permission_level }}">
                                                        <i class="bi bi-pencil" data-bs-toggle="tooltip" title="Sửa"></i>
                                                    </button>
                                                    <form action="{{route('users.destroy',$user->id)}}" method='post'>
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="border-0"><i class="bi bi-trash " onclick="return confirm('Bạn có muốn xóa người dùng này không')" data-bs-toggle="tooltip" title="Xóa"></i></button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan='6' class="text-center text-danger">Không tìm thấy người dùng</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{$users->links()}}
                            </div>
                        </div>
                    </div>
                </main>
            </main>
        </div>
    </div>

    <div class="modal fade " id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg d-flex justify-content-center align-items-center vh-100 ">
            <form action="{{route('users.store')}}" method="post" autocomplete="off">
                @csrf
                <input type="text" name="fakeusername" autocomplete="off" style="display: none;">
                <input type="password" name="fakepassword" autocomplete="new-password" style="display: none;">
                <div class="modal-content p-2">
                    <div class="modal-header">
                        <h3>Thêm người dùng</h3>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <input type="text" style="display:none;" name="username" class="form-control " value=""> -->
                        <div class="mb-3">
                            <label class="form-label" for="">Tên người dùng</label>
                            <input type="text" name="username" class="form-control " autocomplete="off" value="{{old('username')}}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" value="{{old('email')}}" required>
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-flex align-items-center">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>
                            {{$message}}
                        </div>
                        @enderror
                        <div class="mb-3">
                            <label class="form-label" for="">Mật khẩu(ít nhất 8 kí tự)</label>
                            <input type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog ">

            <div class="modal-content">
                <div class="modal-header">
                    <h3>Chi tiết người dùng</h3>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-6">Tên người dùng</div>
                        <div class="col-md-6" id="detail-username"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">Email</div>
                        <div class="col-md-6" id="detail-email"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">Quyền</div>
                        <div class="col-md-6" id="detail-permission_level"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg d-flex justify-content-center align-items-center vh-100 ">
            <form id="updateUser" method="post">
                @csrf
                @method('put')
                <div class="modal-content p-2">
                    <div class="modal-header">
                        <h3>Chỉnh sửa người dùng</h3>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="">Tên người dùng</label>
                            <input type="text" name="username" id="edit-username" class="form-control " value="{{old('username')}}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Email</label>
                            <input type="email" name="email" id="edit-email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" required>
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-flex align-items-center">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>
                            {{$message}}
                        </div>
                        @enderror
                        <div class="mb-3">
                            <label class="form-label" for="">Quyền</label>
                            <select name="permission_level" id="edit-permission_level" class="form-control" required>
                                <option value="read">read</option>
                                <option value="edit">edit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ($errors->any())
    <script>
        $(document).ready(function() {
            @if(session('modal') === 'add')
            $('#addModal').modal('show');
            @elseif(session('modal') === 'edit' && session('edit_id'))
            let editId = @json(session('edit_id'));
            $('#editModal').modal('show');
            $('#updateUser').attr('action', '/users/' + editId);
            @endif
        });
    </script>
    @endif
</body>
<script>
    $(document).ready(function() {
        $('.detail-btn').on('click', function() {
            const username = $(this).data('username');
            const email = $(this).data('email');
            const role = $(this).data('role');
            const permission_level = $(this).data('permission_level');

            $('#detail-username').text(username);
            $('#detail-email').text(email);
            $('#detail-role').text(role);
            $('#detail-permission_level').text(permission_level);
        });
        $('.edit-user').on('click', function() {
            const id = $(this).data('id');
            const username = $(this).data('username');
            const email = $(this).data('email');
            const permission_level = $(this).data('permission_level');

            $('#updateUser').attr('action', '/users/' + id);
            $('#edit-username').val(username);
            $('#edit-email').val(email);
            $('#edit-permission_level').val(permission_level);
        });
        $('#editModal').on('hidden.bs.modal', function() {
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();
        });
        $('#addModal').on('hidden.bs.modal', function() {
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();
        });
        $('[data-bs-toggle="tooltip]').tooltip();
    })
</script>

</html>