@extends('layouts.admin', ['pageTitle' => 'مدیریت مناطق', 'icon'=>'fa-home','newButton' => false])
@section('content')

    <style>
        * {
            box-sizing: border-box
        }


        .tablink {
            background-color: white;

            float: left;
            border: solid 1px green;
            outline: none;
            cursor: pointer;
            padding: 8px 2px;
            font-size: 20px;
            font-weight: bold;
            width: 50%;
            border-bottom: 0;
        }

        .tablink:hover {
            background-color: #adcebb;
        }

        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            color: black;
            display: none;
            padding: 15px 15px;
            height: 100%;
        }




        table,
        th,
        td {
            border-collapse: collapse;
            /* padding: 2px 3px; */
            text-align: center;
            background-color: rgb(240, 231, 231)
                /* box-shadow: 10px 10px 10px rgb(156, 199, 39); */
        }

        input[type='button'] {
            font: 15px Calibri;
            cursor: pointer;
            border: none;
            color: #FFF;
        }

        input[type='text'],
        select {
            font: 17px Calibri;
            text-align: center;
            border: solid 1px #CCC;
            width: 50%;
            padding: 2px 3px;
        }

    </style>



    <body>

        <div class="panel-body">
            <button class="tablink" onclick="openPage('citys', this, 'greenyellow')"
                style="border-radius: 4px 0px 0px 0px;">شهرها</button>
            <button class="tablink" onclick="openPage('provinces', this, 'greenyellow')"
                style="border-radius: 0px 4px 0px 0px;" id="defaultOpen">استان ها</button>

            <div id="provinces" class="tabcontent table-responsive"
                style="border: solid 1px green;border-radius: 0px 0px 4px 4px;">
                <button href="#" class="btn btn-primary" data-toggle="modal" data-target="#createNewProvinceModal">استان
                    جدید</button>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>استان</td>
                            <td>تاریخ</td>
                            <td>ویرایش</td>
                            <td>حذف</td>
                        </tr>
                    </thead>

                    <body>
                        @foreach ($provinces as $province)
                            <tr>
                                <td>{{ $province->name }}</td>
                                <td style="direction:ltr; text-align:center;">
                                    {{ jdate('Y/m/j H:i', strtotime($province->created_at)) }}
                                </td>
                                <td>
                                    <button onclick="openEditProvinceModal('{{ $province->id }}','{{ $province->name }}')"
                                        type="button" class="btn btn-xs btn-success" data-toggle="modal"><i
                                            class="fas fa-edit"></i>ویرایش</button>
                                </td>
                                <td>
                                    <form id="destroy-form-{{ $province->id }}" method="post"
                                        action="{{ route('areas.destroy', $province) }}" style="display:none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                    <button type="submit" onclick='destroy({{ $province->id }});'
                                        class="btn btn-xs btn-danger" data-toggle="tooltip"><i class="fa fa-trash"
                                            aria-hidden="true"></i>حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </body>
                </table>
            </div>

            <div id="citys" class="tabcontent table-responsive"
                style="border: solid 1px green;border-radius: 0px 0px 4px 4px;">
                <button href="#" class="btn btn-primary" data-toggle="modal" data-target="#createNewCityModal">شهرستان
                    جدید</button>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>استان</td>
                            <td>شهرستان</td>
                            <td>تاریخ</td>
                            <td>ویرایش</td>
                            <td>حذف</td>
                        </tr>
                    </thead>

                    <body>
                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $city->province->name }}</td>
                                <td>{{ $city->name }}</td>
                                <td style="direction:ltr; text-align:center;">
                                    {{ jdate('Y/m/j H:i', strtotime($province->created_at)) }}
                                </td>
                                <td>
                                    <button
                                        onclick="openEditCityModal('{{ $city->id }}','{{ $city->province->name }}','{{ $city->name }}')"
                                        type="button" class="btn btn-xs btn-success" data-toggle="modal"><i
                                            class="fas fa-edit"></i>ویرایش</button>
                                </td>
                                <td>
                                    <form id="destroy-form-{{ $city->province_id }}-{{ $city->id }}" method="post"
                                        action="{{ route('cities.destroy', $city->id) }}" style="display:none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                    <button type="submit" onclick='destroy("{{ $city->province_id }}-{{ $city->id }}");'
                                        class="btn btn-danger btn-xs" data-toggle="tooltip"><i class="fa fa-trash"
                                            aria-hidden="true"></i>حذف
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </body>
                </table>
            </div>
        </div>

        {{-- =========modal for edit============ --}}
        <div class="modal fade" id="editModalProvince" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 150px;width: -moz-fit-content;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">ویرایش</h5>
                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -20px"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" id="editProvinceForm" style="margin: 20px 50px;">
                        @csrf
                        <input type="hidden" name="_method" value="put" />
                        <input type="hidden" name="id" id="editProvinceId" />
                        <label for="name">نام استان</label>
                        <input name="name" type="text" value="" class="form-control" id="editProvinceName">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModalCity" tabindex="-1" role="dialog" aria-labelledby="editLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 150px;width: -moz-fit-content;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLabel">ویرایش</h5>
                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -20px"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" id="editCityForm" style="margin: 20px 50px;">
                        @csrf
                        <input type="hidden" name="_method" value="put" />
                        <input type="hidden" name="id" id="editCityId" />
                        <label for="name">نام استان</label>
                        <select class="form-control" name="province_id" id="editProvinceCityName">
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                        <label for="name">نام شهرستان</label>
                        <input name="name" type="text" value="" class="form-control" id="editCityName">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- =================modal for create=============== --}}
        <div class="modal fade" id="createNewCityModal" tabindex="-1" role="dialog"
            aria-labelledby="createNewCityModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 150px;width: -moz-fit-content;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNewCityModalLabel">ایجاد شهرستان</h5>
                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -20px"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('cities.store') }}" style="margin: 20px 50px;">
                        @csrf
                        <div class="form-group">
                            <label for="nameProvine">نام استان</label>
                            <select class="form-control" name="province_id" style="width:50%">
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="name">نام شهرستان</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control" required
                                oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="createNewProvinceModal" tabindex="-1" role="dialog"
            aria-labelledby="createNewProvinceModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 150px;width: -moz-fit-content;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNewProvinceModalLabel">ایجاد استان</h5>
                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -20px"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" class="d-flex flex-row " action="{{ route('areas.store') }}"
                        style="margin: 20px 50px;">
                        @csrf
                        <div class="form-group">
                            <label for="name">نام استان</label>
                            <input name="name" type="text" style="width:50%" value="{{ old('name') }}" class="form-control"
                                required oninvalid="setCustomValidity('این فیلد اجباری است')"
                                oninput="setCustomValidity('')">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function openEditProvinceModal(id, name) {
                $("#editProvinceId").val(id);
                $("#editProvinceName").val(name);
                $("#editProvinceForm").attr("action", "areas/" + id);
                $("#editModalProvince").modal();
            }

            function openEditCityModal(cityId, provinceName, Cityname) {
                $("#editCityId").val(cityId);
                // $("#editProvinceCityName").val(provinceId);
                $("#editProvinceCityName").val(provinceName);
                $("#editCityName").val(Cityname);
                $("#editCityForm").attr("action", "cities/" + cityId);
                $("#editModalCity").modal();
            }

            function openPage(pageName, elmnt, color) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablink");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].style.backgroundColor = "";
                }
                document.getElementById(pageName).style.display = "block";
                elmnt.style.backgroundColor = color;
            }
            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();

        </script>

    </body>

@endsection
