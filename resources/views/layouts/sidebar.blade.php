  {{-- <button class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button> --}}
  {{--
  <link href="/simple-sidebar.css" rel="stylesheet" type="text/css"> --}}
  <style>
      .sidebar {
          background-color: #f1f1f1;
          position: fixed;
          height: 100%;
          overflow: auto;
      }

      .sidebar a {
          display: block;
          color: black;
          padding: 16px;
          text-decoration: none;
      }

      .sidebar a.active {
          background-color: #4CAF50;
          color: white;
      }


      div.content {
          margin-left: 200px;
          padding: 1px 16px;
          height: 1000px;
      }

      @media screen and (max-width: 700px) {
          .sidebar {
              width: 100%;
              height: auto;
              position: relative;
          }

          div.content {
              margin-right: 0;
          }
      }

      @media screen and (max-width: 400px) {
          .sidebar a {
              text-align: center;
              float: none;
          }
      }

  </style>
  <div id="navbarContent" class="navbar-default sidebar d-flex" role=" navigation" style="margin-top: 50px">
      <div class="collapse sidebar-nav navbar-collapse">
          <ul class="nav" id="side-menu" style="background-color: aliceblue;">
              <li class="nav-item">
                  <a href="{{ route('monitorings.index') }}" class="active" style="color: green"><i class="fa fa-laptop"
                          aria-hidden="true"></i>مانیتورینگ</a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('map') }}" style="color: green"><i class="fas fa-map"></i> نقشه</a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('areas.index') }}" style="color: green"><i class="fa fa-home"></i> مدیریت
                      مناطق</a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('stations.index') }}" style="color: green"><i class="fa fa-building"></i> مدیریت
                      ایستگاه ها</a>
              </li>
              <li class="dropdown" style="display: grid">
                  <a href="#" style="color: green" class="dropdown-toggle" data-toggle="dropdown" role="button"
                      aria-haspopup="true" aria-expanded="false"><i class="fa fa-tree fa-fw"></i> مدیریت گیاهان<span
                          class="fa arrow"></span></a>
                  <ul class="dropdown-menu "
                      style="position: relative;top:0px;background-color:rgba(233, 222, 222, 0.15);border-radius:0px">
                      <li class="nav-item">
                          <a href="{{ route('plants.index') }}" style="color: green"> لیست گیاهان</a>
                      </li>
                      <li class="nav-item" style="border-bottom:0px solid #e7e7e7">
                          <a href="{{ route('degreeDayPlants.index') }}" style="color: green"> درجه روز گیاه</a>
                      </li>
                  </ul>
              </li>
              <li class="dropdown" style="display: grid">
                  <a href="#" class="dropdown-toggle" style="color: green" data-toggle="dropdown" role="button"
                      aria-haspopup="true" aria-expanded="false"><i class="fa fa-bug fa-fw"></i> مدیریت آفت ها<span
                          class="fa arrow"></span></a>
                  <ul class="dropdown-menu"
                      style="position: relative;top:0px;background-color:rgba(233, 222, 222, 0.15);border-radius:0px">
                      <li>
                          <a href="{{ route('pests.index') }}" style="color: green"> لیست آفت ها</a>
                      </li>
                      <li style="border-bottom:0px solid #e7e7e7">
                          <a href="{{ route('degreeDayPests.index') }}" style="color: green"> درجه روز آفت</a>
                      </li>
                  </ul>
              </li>
              <li class="nav-item">
                  <a href="{{ route('illnesses.index') }}" style="color: green"><i class="fas fa-disease"></i> مدیریت
                      بیماری
                      ها</a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('reports.index') }}" style="color: green"><i class="fa fa-file-text"></i> گزارش
                      ها</a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('dangers.index') }}" style="color: green"><i class="fa fa-exclamation-triangle"
                          aria-hidden="true"></i> مخاطرات</a>
              </li>
              <li class="nav-item">
                  <a href="/tempManage" style="color: green"><i class="fa fa-thermometer-three-quarters"></i> مدیریت
                      دما</a>
              </li>
              {{-- <li class="nav-item">
                  <a href="/Frostbite" style="color: green"><i class="fas fa-asterisk"></i> اعلام سرمازدگی</a>
              </li> --}}
              @role('admin')
              <li class="dropdown" style="display: grid">
                  <a href="#" class="dropdown-toggle" style="color: green" data-toggle="dropdown" role="button"
                     aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i> مدیریت کاربران<span
                          class="fa arrow"></span></a>
                  <ul class="dropdown-menu"
                      style="position: relative;top:0px;background-color:rgba(233, 222, 222, 0.15);border-radius:0px">
                      <li>
                          <a href="{{ route('users.index') }}" style="color: green"> لیست کاربران</a>
                      </li>
                      <li style="border-bottom:0px solid #e7e7e7">
                          <a href="{{ route('permissions.index') }}" style="color: green">نقش ها و مجوزها</a>
                      </li>
                  </ul>
              </li>
              @endrole
              <li class="nav-item">
                  <a href="{{ route('logout') }}" onclick="logout()" style="color: green"><i class="icon-signout"></i>
                      خروج</a>
                  <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                      @csrf
                  </form>
              </li>
          </ul>
      </div>
  </div>


  <script>
      function logout() {
          event.preventDefault();

          swal({
              title: "آیا برای خروج اطمینان دارید؟",
              icon: "warning",
              buttons: ["انصراف", "خروج"],
              dangerMode: true,
          }).then((willExit) => {
              if (willExit)
                  document.getElementById('logout-form').submit();
          });
      }

  </script>
