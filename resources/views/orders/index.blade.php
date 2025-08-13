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

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>

</head>

<body class="bg-light">
    <div class="d-flex">
        @include('partials.sidebar')
        <div class="flex-grow-1 ">
            @include('partials.header',['pageTitle'=>'Đơn hàng'])
            <main class="container-fluid">
                <main class="p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{route('orders.index')}}" method="get">
                                <div class="row align-items-center pb-3 border-bottom">
                                    <div class="col-md-2 ">
                                        <input type="phone" class="search-phone form-control" placeholder="Tìm theo SĐT" name="phone" value="{{request('phone')}}" onchange="this.form.submit()">
                                    </div>
                                    <div class="col-md-2 ">
                                        <input type="text" class="search-name form-control" placeholder="Tìm theo tên " name="receiver_Name" value="{{request('receiver_Name')}}" onchange="this.form.submit()">
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="d-flex align-items-center gap-2">
                                            <span> Ngày:</span>
                                            <input type="date" class="start-date form-control" name="start_date" value="{{request('start_date')}}" onchange="this.form.submit()">
                                            <span class="align-self-center">→</span>
                                            <input type="date" class="end-date form-control" name="end_date" value="{{request('end_date')}}" onchange="this.form.submit()">
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center col-auto ms-auto">

                                        <div class="me-2">
                                            <input type="hidden" id="sort_by" name="sort_by" value="total_price">
                                            <select class="form-select price-sort" name="sort_order" onchange="this.form.submit()">
                                                <option value="">Tổng tiền</option>
                                                <option value="asc" {{request('sort_order')=='asc'?'selected':''}}>Thấp -> Cao</option>
                                                <option value="desc" {{request('sort_order')=='desc'?'selected':''}}>Cao -> Thấp</option>
                                            </select>
                                        </div>
                                        <div>
                                            <a href="{{route('orders.export')}}" class="export-file btn btn-secondary"><i
                                                    class=" bi bi-file-earmark-arrow-down"></i>Xuất
                                                file</a>
                                        </div>

                                    </div>
                                </div>
                            </form>

                            <div class="table-container mt-2 shadow-sm rounded">
                                <table class="table table-hover table-borderless table-striped ">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày đặt</th>
                                            <th>Tên</th>
                                            <th>SĐT</th>
                                            <th>Giá</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-list">
                                        @foreach($orders as $index =>$order)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
                                            <td>{{$order->receiver_Name}}</td>
                                            <td>{{$order->phone}}</td>
                                            <td>{{number_format($order->total_price)}}đ</td>
                                            <td class="text-end fs-5">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{route('orders.show',$order->id)}}" class="text-dark">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="{{route('orders.destroy',$order->id)}}" method='post'>
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="border-0">
                                                            <i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$orders->links()}}
                            </div>
                        </div>
                    </div>
                </main>
            </main>
        </div>
    </div>
    </div>
</body>


</html>