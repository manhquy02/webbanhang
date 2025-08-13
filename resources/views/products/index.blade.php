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
    <title>Product</title>
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
            @include('partials.header',['pageTitle'=>'Sản phẩm'])
            <main class="container-fluid ">
                <main class="p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form id="filterForm" action="{{route('products.index')}}" method="GET">
                                <div class="row align-items-center pb-3 border-bottom">
                                    <div class="col-md-3">

                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" class="form-control search-name" name='name_product'
                                                placeholder="Tìm theo tên sản phẩm" value="{{request('name_product')}}" onchange="this.form.submit()">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-filter"></i></span>
                                            <select name="category_id" class="category-filter form-select" onchange="this.form.submit()" required>
                                                <option value="">Tất cả danh mục</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{request('category_id')==$category->id ? 'selected':''}}>{{$category->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">

                                        <input name="sort_by" type="hidden" id="sort_by" value="price">
                                        <select name="sort_order" id="price-sort" class="form-select" onchange="this.form.submit()">
                                            <option value="">Giá</option>
                                            <option value="desc" {{request('sort_order')=='desc'?'selected':''}}>Cao -> Thấp</option>
                                            <option value="asc" {{request('sort_order')=='asc'?'selected':''}}>Thấp -> Cao</option>
                                        </select>
                                    </div>
                            </form>
                            <div class="col-md-4 text-end">
                                <a href="{{route('products.export')}}" class="btn btn-secondary me-2"><i
                                        class="bi bi-file-earmark-arrow-down me-1"></i>Xuất file
                                </a>
                                @can('edit-content')
                                <button type="button" class="add-product btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#myModal"> <i class="bi bi-plus-circle me-1"></i>Thêm
                                    sản phẩm</button>
                                @endcan
                            </div>
                        </div>

                        <div class="table-responsive mt-2 shadow-sm rounded">
                            <table class="table table-hover table-striped table-borderless">
                                <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th class="text-end">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    @foreach($products as $index => $product)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>
                                            <img src="{{ asset('storage/images/' .$product->image)}}" alt="{{$product->name_product}}" style="width:80px;height:80px;object-fit: cover;border-radius:8px">
                                            {{$product->name_product}}
                                        </td>
                                        <td>{{$product->category->name}}</td>
                                        <td>
                                            <span class="badge {{$product->stock >0 ? 'bg-success-subtle text-success p-2' : 'bg-danger-subtle text-danger p-2'}}">
                                                {{$product->stock >0 ? 'Còn hàng' :'Hết hàng'}}
                                            </span>
                                        </td>
                                        <td>{{$product->stock}}</td>
                                        <td>{{number_format($product->price)}}đ</td>
                                        <td class="text-end fs-5">
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="edit-product border-0" data-bs-toggle="modal" data-bs-target="#myModal"
                                                    data-id="{{$product->id}}"
                                                    data-name="{{ $product->name_product}}"
                                                    data-price="{{ $product->price}}"
                                                    data-category="{{ $product->category_id}}"
                                                    data-stock="{{ $product->stock}}"
                                                    data-description="{{ $product->description}}"
                                                    data-image="{{ $product->image}}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{route('products.destroy',$product->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type='submit' class="border-0">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{$products->links()}}
                        </div>

                    </div>
        </div>
        </main>
    </div>
    </main>
    </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="productForm" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                @if($errors->any())
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel">Thêm sản phẩm</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" class="product-id">
                        <input type="hidden" class="old-image">
                        <div class="mb-3">
                            <label for="insert-name" name="name_product" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control insert-name" id="name_product" name="name_product" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" class="form-control price" id="price" name="price" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="insert-category" class="form-label">Danh mục</label>

                            <select name="category_id" class="category-filter form-select" name="category_id" required>
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="insert-quantity" class="form-label">Số lượng</label>
                            <input type="number" class="form-control insert-quantity" id="stock" name="stock" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="insert-description" class="form-label">Mô tả</label>
                            <textarea class="form-control insert-description" id="description" name="description" required
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="insert-image" class="form-label">Ảnh sản phẩm</label>
                            <input type="file" class="form-control insert-image" id="image" name="image" accept="image/*">
                            <img src="" alt="Preview" class="preview-image" style="max-width: 100px; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success submit-product" data-type="insert">Lưu</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('.edit-product').click(function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            let category = $(this).data('category');
            let stock = $(this).data('stock');
            let description = $(this).data('description');
            let image = $(this).data('image');
            let imageUrl = '/storage/images/' + image;

            $('#productForm').attr('action', '/products/' + id);
            $('#formMethod').val('put');

            $('#name_product').val(name);
            $('#name_product').val(name);
            $('#price').val(price);
            $('select[name="category_id"]').val(category);
            $('#stock').val(stock);
            $('#description').val(description);

            if (image) {
                $('.preview-image').attr('src', imageUrl).show();
            } else {
                $('.preview-image').hide();
            }

            $('#myModalLabel').text('Cập nhật sản phẩm');

            $('.submit-product').text('Cập nhật');
        })
        $('.add-product').click(function() {
            $('#productForm').attr('action', '{{route("products.store")}}');
            $('#formMethod').val('post');

            $('#myModalLabel').text('Thêm sản phẩm');
            $('.submit-product').text('Lưu');

            $('#name_product').val('');
            $('#price').val('');
            $('select[name="category_id"]').val('');
            $('#stock').val('');
            $('#description').val('');
            $('#image').attr('required', true);
            $('.preview-image').hide();
        });
    });
</script>

</html>