<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container-fluid">
    <h3 id="show-name" class="ms-4">{{$pageTitle ?? ''}}</h3>
    <div class="me-3" id="user-dropdown">
      <div class="dropdown d-flex align-items-center gap-2">
        <button
          class="btn btn-light border rounded-circle d-flex align-items-center justify-content-center"
          style="width: 42px; height: 42px;" data-bs-toggle="dropdown"><i class="bi bi-person"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <span class="dropdown-item">Tên:{{ Auth::user()->username }}</span>
            <span class="dropdown-item">Email:{{ Auth::user()->email }}</span>
            <form action="{{route('logout')}}" method="post">
              @csrf
              <button type="submit" class="dropdown-item fw-bold">Đăng xuất</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>