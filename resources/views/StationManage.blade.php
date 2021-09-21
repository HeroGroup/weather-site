@extends('layouts.admin', ['pageTitle' => 'مدیریت ایستگاه ها', 'newButton' => false])
@section('content')
    <!-- Button trigger modal -->

    <style>
        * {
            box-sizing: border-box
        }

        /* Set height of body and the document to 100% */


        /* Style tab links */

        .tablink {
            background-color: white;

            float: left;
            border: solid 4px green;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
        }

        .tablink:hover {
            background-color: #adcebb;
        }

        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            color: black;
            display: none;
            padding: 100px 20px;
            height: 100%;
        }

        table,
        th,
        td {
            border: solid 3px #f1c40f;
            border-collapse: collapse;
            padding: 2px 3px;
            text-align: center;
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
            width: auto;
            padding: 2px 3px;
        }

    </style>

    <body>

        <div class="col-md-8">

            {{-- <button class="tablink"
                onclick="openPage('Contact', this, 'blue')">Contact</button>
            <button class="tablink" onclick="openPage('About', this, 'orange')">About</button>
            --}}

            <button class="tablink" id="defaultOpen" onclick="openPage('stations', this, 'green')">ایستگاه ها</button>
            {{-- <button class="tablink"
                onclick="openPage('Contact', this, 'blue')">Contact</button>
            <button class="tablink" onclick="openPage('About', this, 'orange')">About</button>
            --}}

            <div id="stations" class="tabcontent" style="border: solid 4px green;">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createNewStateModal"
                    style="font-size:large">ایستگاه جدید</a>
                <hr>
                <table class="table" style="font-size:large;">
                    <thead>
                        <tr>
                            <td>عملیات</td>
                            <td>نام ایستگاه</td>
                            <td>عرض جغرافیایی</td>
                            <td>طول جغرافیایی</td>
                            <td>حذف</td>
                        </tr>
                    </thead>

                </table>
            </div>


        </div>


        <div class="modal fade" id="createNewStateModal" tabindex="-1" role="dialog"
            aria-labelledby="createNewStateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 120px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNewStateModalLabel" style="font-size: large">ایجاد ایستگاه جدید
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" style="margin-top: -20px"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('areas.store') }}" style="margin: 20px 50px;">
                        @csrf
                        <div class="row">
                            <div>
                                <label for="name">شهر</label>
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>
                            <div>
                                <label for="name">کد دستگاه</label>
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>

                        </div>

                        <div class="row">
                            <div>
                                <label for="name">نوع</label>
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>
                            <div>
                                <label for="name">عنوان دستگاه</label>
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div>

                                <label for="name">تلفن همراه</label>
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>
                            <div>

                                <label for="name">IP</label>
                                <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="name">نوع ارتباط</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control">
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
    @endsection
