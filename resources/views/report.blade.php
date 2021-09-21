@extends('layouts.admin', ['pageTitle' => 'گزارش ها', 'newButton' => false])
@section('content')

    <style>
        * {
            box-sizing: border-box
        }

        /* Set height of body and the document to 100% */


        /* Style tab links */
        .navbar-nav {
            background-color: #555;
            color: white;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 2px;
            font-size: 17px;
            width: 100px;
            border: 1px solid black;
        }

        .navbar-nav:hover {
            background-color: #777;
        }

        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            color: rgb(32, 29, 29);
            display: none;
            padding: 100px 20px;
            height: 100%;
        }



        #DailyReport {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #PeriodicReport {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #HourlyReport {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #AnnualReport {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #CoolingNeed {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #TemperatureThreshold {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #TemperatureReport {
            background-color: rgba(198, 204, 185, 0.87);
        }

        #PestReport {
            background-color: rgba(198, 204, 185, 0.87);
        }

    </style>
    </head>
    <div class="row navbar navbar-expand-lg navbar-light bg-light">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <button class="navbar-nav mr-auto" style="float: right"
                onclick="openPage('DailyReport', this, ' rgba(0, 102, 128, 0.562)')">گزارش روزانه</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('PeriodicReport', this, ' rgba(0, 102, 128, 0.562)')" id="defaultOpen">گزارش دوره
                ای</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('HourlyReport', this, ' rgba(0, 102, 128, 0.562)')">گزارش ساعتی</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('AnnualReport', this, ' rgba(0, 102, 128, 0.562)')">گزارش سالانه</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('CoolingNeed', this, ' rgba(0, 102, 128, 0.562)')">نیاز سرمایی</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('TemperatureThreshold', this, ' rgba(0, 102, 128, 0.562)')">آستانه دما-نمناکی</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('TemperatureReport', this, ' rgba(0, 102, 128, 0.562)')">گزارش درجه-روز گیاه</button>
            <button class="navbar-nav" style="float: right"
                onclick="openPage('PestReport', this, ' rgba(0, 102, 128, 0.562)')">گزارش درجه-روز آفت</button>

        </div>
    </div>
    <div id="DailyReport" class="tabcontent">
        <h3>گزارش روزانه</h3>
        <p>Home is where the heart is..</p>
    </div>

    <div id="PeriodicReport" class="tabcontent">
        <h3>گزارش دوره ای</h3>
        <p>Some news this fine day!</p>
    </div>

    <div id="HourlyReport" class="tabcontent">
        <h3>گزارش ساعتی</h3>
        <p>Get in touch, or swing by for a cup of coffee.</p>
    </div>

    <div id="AnnualReport" class="tabcontent">
        <h3>گزارش سالانه</h3>
        <p>Who we are and what we do.</p>
    </div>
    <div id="CoolingNeed" class="tabcontent">
        <h3>نیاز سرمایی</h3>
        <p>Who we are and what we do.</p>
    </div>
    <div id="TemperatureThreshold" class="tabcontent">
        <h3>آستانه دما-نمناکی</h3>
        <p>Who we are and what we do.</p>
    </div>
    <div id="TemperatureReport" class="tabcontent">
        <h3>گزارش درجه-روز گیاه</h3>
        <p>Who we are and what we do.</p>
    </div>
    <div id="PestReport" class="tabcontent">
        <h3>گزارش درجه-روز آفت</h3>
        <p>Who we are and what we do.</p>
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
