<nav class="navbar navbar-expand-lg bg-white shadow-sm">
  <div class="container-fluid">
    <h3 id="show-name" class="ms-4">{{$pageTitle ?? ''}}</h3>
    <div class="me-5" id="user-dropdown">
         <div class="dropdown d-flex align-items-center gap-2">
                    <button
                        class="btn btn-light border rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px;" data-bs-toggle="dropdown"><i class="bi bi-person"></i>
                      
                    </button>
                    
                      @if(Auth::check())
                          <span>{{ Auth::user()->email }}</span>
                      @endif

                   
                    <ul class="dropdown-menu">
                      <li>
                       
                      <form action="{{route('logout')}}" method="post">
                        @csrf
                         <button type="submit" class="dropdown-item">Đăng xuất</button>
                          </form>
                      </li>
                       
                       
                    </ul>
                   
                </div>
    </div>
  </div>
</nav>