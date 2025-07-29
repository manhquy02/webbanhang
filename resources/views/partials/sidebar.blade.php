<div id="sidebar" class="d-flex flex-column flex-shrink-0 shadow-sm border-end"
  style="width: 250px; height:100vh;background-color:  #1f2937">
  <a href="#" class="d-flex align-items-center mb-4 pb-3 mx-3 mt-3 border-bottom text-decoration-none">
    <i class="bi bi-grid-fill me-2 fs-4" style="color: #6C63FF;"></i>
    <span class="fs-5 fw-bold text-white">QUẢN TRỊ ABCDE</span>
  </a>

  <ul class="nav nav-pills flex-column mb-auto px-3">


    <li class="nav-item my-1">
      <a href="{{route('products.index')}}" class="nav-link rounded text-white">
        <i class="bi bi-box-seam me-2 fs-5"></i>
        Sản phẩm
      </a>
    </li>

    <li class="nav-item my-1">
      <a href="{{route('users.index')}}" class="nav-link rounded text-white">
        <i class="bi bi-people me-2 fs-5"></i>
        Người dùng
      </a>
    </li>

    <li class="nav-item my-1">
      <a href="{{route('orders.index')}}" class="nav-link rounded text-white">
        <i class="bi bi-receipt me-2 fs-5"></i>
        Đơn hàng
      </a>
    </li>


  </ul>
  <div class="mt-auto p-3 border-top text-center  text-white">
    <small>&copy; 2025 Your Company</small>
  </div>

</div>