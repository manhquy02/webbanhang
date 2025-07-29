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

    <title>Document</title>
    <style>
         body {
            font-family: 'Poppins', sans-serif;
        }
        .table td, .table th {
        vertical-align: middle;
        }
        
    </style>

</head>

<body class="bg-light">
    <div class="d-flex">
       @include('partials.sidebar')
        <div class="flex-grow-1">
           @include('partials.header',['pageTitle'=>'Người dùng'])
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
                                            <th>Vai trò</th>
                                            <th>Quyền</th>
                                            <th class="text-end ">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-list">
                                        @foreach($users as $index => $user)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->role}}</td>
                                           
                                            <td>
                                                <!-- <select name="permission_level" class='form-select'>
                                                    <option  value="none">None</option>
                                                    <option value="read">Read</option>
                                                    <option value="fix">Fix</option>
                                                </select> -->
                                                {{$user->permission_level}}
                                            </td>
                                           
                                            <td class="text-end fs-5">
                                                <i class="bi bi-pencil-square"></i>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {{$users->links()}}
                            </div>
                          
                            

                        </div>

                    </div>
        </div>
        </main>
        </main>

    </div>
    </div>
</body>


</html>