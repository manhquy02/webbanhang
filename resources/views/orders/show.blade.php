<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>

</head>

<body class="pb-light">
    <div class="d-flex">
        @include('partials.sidebar')
        <div class="flex-grow-1">
            @include('partials.header',['pageTitle'=>'Chi tiết đơn hàng'])
            <div class="container ">
                <div class="d-flex align-items-center gap-2 my-2 mx-3">
                    <h4 class="mb-0">
                        <a href="{{route('orders.index')}}" class="text-secondary text-decoration-none d-flex align-items-center">
                            <i class="bi bi-house-door-fill me-1"></i> Đơn hàng
                        </a>
                    </h4>
                    <i class="bi bi-chevron-right text-muted"></i>
                    <h4 class="mb-0 text-dark ">Chi tiết đơn hàng</h4>
                </div>
                <div id="history-orders"></div>
            </div>
            <div class="container-fluid">
                <div class="p-3">
                    <div class="row min-vh-100">
                        <div class="col-md-7">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Chi tiết đơn hàng</h5>
                                    @foreach($order->items as $index => $items)
                                    <div class="d-flex justify-content-between border-bottom py-2">
                                        <div class="dme-3-flex justify-content-between">
                                            <img src="{{ asset('storage/images/' .$items->product->image)}}" alt="{{$items->product->name_product}}" style="width:80px;height:80px;object-fit: cover;border-radius:8px">
                                        </div>
                                        <div class="flex-grow-1 mx-2">
                                            <p class="fw-bold">{{$items->product->name_product}}</p>
                                            <p>{{$items->product->category->name}}</p>
                                        </div>
                                        <div class="text-end py-3">
                                            <p class="border p-2 rounded fw-bold">{{($items->quantity)}}x{{number_format($items->price)}}đ</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="text-end pt-3 fw-bold">
                                        <p>Tổng: {{number_format($order->total_price)}}đ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 ">
                            <div class="card">
                                <div class="card-body ">
                                    <h5 class="mb-3">Thông tin người dùng</h5>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Tên</div>
                                        <div class="col-md-6">{{$order->user->username ?? '-'}}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Email</div>
                                        <div class="col-md-6">{{$order->user->email ?? '-'}}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Ngày đặt</div>
                                        <div class="col-md-6">{{$order->created_at}}</div>
                                    </div>
                                    <div class="row mb-2 ">
                                        <div class="col-md-6">SĐT</div>
                                        <div class="col-md-6  pb-5">{{$order->phone}}</div>
                                    </div>
                                    <h5 class="mb-3">Thông tin người nhận</h5>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Tên người nhận</div>
                                        <div class="col-md-6">{{$order->receiver_Name}}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Địa chỉ nhận</div>
                                        <div class="col-md-6">{{$order->detail_address}}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Tỉnh/Thành</div>
                                        <div class="col-md-6">{{$order->province->name}}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Quận/Huyện</div>
                                        <div class="col-md-6">{{$order->district->name}}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">Phường/Xã</div>
                                        <div class="col-md-6">{{$order->ward->name}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>