@extends('layouts.admin', ['pageTitle' => 'ایستگاه '.$station->device_code, 'newButton' => false])
@section('content')
    <style>
        .feature_box_active {
            background-color: #DDD;
        }

        .feature_box {
            height: auto;
            box-shadow: 0 0 15px 0 rgba(0, 0, 0, .10);
            padding: 0 20px;
            text-align: center;
            transition: ease all 0.5s;
            cursor: pointer;
            background-color:  rgba(248, 250, 247, 0.61);
        }

        .feature_box:hover,
        .feature_box:focus {
            background-color: #fc301e;
        }

        .feature_box:hover h4,
        .feature_box:focus h4,
        .feature_box:hover p,
        .feature_box:focus p {
            color: #fff;
        }

        .feature_box:hover img.default-block,
        .feature_box:focus img.default-block {
            display: none;
        }

        .feature_box:hover img.default-none,
        .feature_box:focus img.default-none {
            display: initial;
        }

        .feature_box h4 {
            text-transform: uppercase;
            font-size: 20px;
        }

        .feature_box p {
            font-size: 14px;
            line-height: 22px;
            font-weight: 400;
        }

        .button {
            border-radius: 4px;
            border: none;
            text-align: center;
            font-size: 16px;
            padding: 10px;
            width: 200px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        .button span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        .button:hover span {
            padding-right: 25px;
        }

        .button:hover span:after {
            opacity: 1;
            right: 0;
        }

    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script src="/js/live-sensor-data.js"></script>
    <script>
        setTopic("{{$station->device_code}}");
    </script>

    <div class="row" style="margin: auto;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="live-tab" style="border: 2px solid aliceblue;color:black" data-toggle="tab"
                    href="#live" role="tab" aria-controls="info" aria-selected="false">نمایش لحظه ای</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="report-tab" style="border: 2px solid aliceblue;color:black" data-toggle="tab"
                    href="#report" role="tab" aria-controls="chart" aria-selected="false">گزارش</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent" style="margin-top: 15px">
            <div class="tab-pane active" id="live" role="tabpanel" aria-labelledby="live-tab">
                <div id="home" data-spy="scroll">
                    <div id="content">
                        <div class="section">
                            <div class="container">
                                <div style="display:flex;padding-bottom:25px;">
                                    <h5 style="flex:1;text-align:left;color:rgb(26, 23, 23);padding-left:5px;">آخرین
                                        بروزرسانی</h5>
                                    <h5 style="flex:1;text-align:right;padding-right:5px;" id="last-update"></h5>
                                </div>
                                <div class="row">
                                     <div class="col-md-4 col-6" style="margin-bottom: 20px">
                                        <a href="{{ route('charts.detailChart', ['station' => $station->id, 'param' => 'temp']) }}"
                                            style="color: black;text-decoration:transparent">
                                            <div class="feature_box humidity" >
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="full icon">
                                                            <i class="fas fa-temperature-high fa-5 fa-3dicon"
                                                                aria-hidden="true" style="color:rgb(4, 8, 241);font-size:50px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                         <h4>دمای هوا</h4>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12" style="text-align: center;">
                                                        <h1 style="direction:ltr;">
                                                            <span id="temp">0</span>&nbsp;
                                                            <span>&#xb0;C</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                                        <a href="{{ route('charts.detailChart', ['station' => $station->id, 'param' => 'humidity']) }}"
                                            style="color: black;text-decoration:transparent" style="background: rgba(248, 250, 247, 0.61)">
                                            <div class="feature_box humidity" >
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="full icon">
                                                            <i class="fas fa-tint"
                                                                style="color:rgb(18, 200, 224);font-size:50px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4>رطوبت هوا</h4>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12" style="text-align: center;">
                                                        <h1 style="direction:ltr;">
                                                            <span id="humidity">0</span>&nbsp;
                                                            <span>%</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                                        <a href="{{ route('charts.detailChart', ['station' => $station->id, 'param' => 'w_speed']) }}"
                                            style="color: black;text-decoration:transparent">
                                            <div class="feature_box w_speed" >
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="full icon">
                                                            <i class="fas fa-wind"
                                                                style="color:rgb(47, 179, 231);font-size:50px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4>سرعت باد</h4>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12" style="text-align: center;">
                                                        <h1 style="direction:ltr;">
                                                            <span id="w_speed">0</span>&nbsp;
                                                            <span>m/s</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                                        <a href="{{ route('charts.detailChart', ['station' => $station->id, 'param' => 'w_direction']) }}"
                                            style="color: black;text-decoration:transparent">
                                            <div class="feature_box w_direction" >
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="full icon">
                                                            <i class="fa fa-compass"
                                                                style="color:rgb(32, 148, 28);font-size:50px"
                                                                aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4>جهت باد</h4>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h1 style="direction:ltr;">
                                                            <span id="w_direction">0</span>&nbsp;
                                                            <span>&#xb0;</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                                        <a href="{{ route('charts.detailChart', ['station' => $station->id, 'param' => 'radiation']) }}"
                                            style="color: black;text-decoration:transparent">
                                            <div class="feature_box radiation">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="full icon">
                                                            {{-- <i class="fas fa-sun"
                                                                style="color:rgb(247, 211, 10);font-size:50px"></i> --}}
                                                            <img src="/image/icons8-moisture-80.png" style="height:50px;weight:48px">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4>رطوبت خاک</h4>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12" style="text-align: center;">
                                                        <h1 style="direction:ltr;">
                                                            <span id="radiation">0</span>&nbsp;
                                                            <span>W/m²</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                                        <a href="{{ route('charts.detailChart', ['station' => $station->id, 'param' => 'rain']) }}"
                                            style="color: black;text-decoration:transparent">
                                            <div class="feature_box rain" >
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="full icon">
                                                            <i class='fas fa-cloud-rain'
                                                                style="color:blue;font-size:50px"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h4>میزان بارش</h4>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12" style="text-align: center;">
                                                        <h1 style="direction:ltr;">
                                                            <span id="rain">0</span>&nbsp;
                                                            <span>mm</span>
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">

                <div class="row">
                    <div class="col-md-3">
                        <label for="dayDate">انتخاب تاریخ</label>
                        <input type="text" name="dayDate" id="dayDate" class="custom_date_picker form-control" />
                    </div>
                    <div class="col-md-3" style="margin-top: 24px">
                        <button class="btn" id="report-button" onclick="report()">جستجو</button>
                    </div>
                </div>
                <div style="text-align:center">
                    <img src="/image/loading.gif" class="loader" width="64" height="64"
                        style="display:none;margin-top:10px;" />
                </div>
                <div id="info" style="margin-top:50px;"></div>
            </div>
        </div>
        <a href="{{ route('monitorings.index') }}" class="btn btn-default button" style="margin: 10px"><span>بازگشت به
                منوی
                قبل</span></a>
    </div>

    <script src="/js/custom.js"></script>
    <script src="/js/export-to-excel.js"></script>
    <script src="/js/helpers.js"></script>
    <script>
        // $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        document.getElementById("defaultOpen").click();
        // });

        function openPage(pageName, elmnt) {
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
            elmnt.style.backgroundColor = 'greenyellow';
        }

        function report() {
            $("#info").html("");
            $("#report-button").prop("disabled", true);
            $(".loader").css({
                "display": "inline-block"
            });
            var device = "{{ $station->id }}",
                date = $("#dayDate").val();
                console.log(date);
            $.ajax(`/admin/getDailyReport/${device}/${date}`, {
                success: function(response) {
                    var data = response.data;
                    $(".loader").css({
                        "display": "none"
                    });
                    $("#report-button").prop("disabled", false);
                    var hours = [],
                        result =
                        `<div style="width:100%;text-align:left;">
                         <button class="btn btn-success" onclick="exportTableToExcel('report-data', 'گزارش روزانه')"><i class="fa fa-fw fa-file-excel"></i> خروجی اکسل</button>
                         </div>
                         <br>
                         <div class="table-responsive">
                         <table class="table table-bordered table-hover" id="report-data">
                         <thead>
                         <tr>
                         <th>ساعت</th><th>دما</th><th>رطوبت</th><th>نقطه شبنم</th>
                         </tr>
                         </thead>
                         <tbody>`;


                    if (data.length > 0)
                        for (var z=(data.length)-1;z>=0;z--)
                            hours[data[z].SensorFeatureTime] = JSON.parse(data[z].parameters_values);


                    var minTemp, maxTemp, temperature, minHumidity, maxHumidity, humidity, dewPoint, i = 0,
                        totalMinTemp, totalMaxTemp, totalTemperature, totalMinHumidity, totalMaxHumidity,
                        totalHumidity, totalMinDewPoint, totalMaxDewPoint, totalDewPoint,
                        minTempHour, maxTempHour, temperatureHour, minHumidityHour, maxHumidityHour,
                        humidityHour, minDewPointHour, maxDewPointHour, dewPointHour;

                    for (const hour in hours) {
                        if (hours[hour]) {
                            temperature = parseFloat(hours[hour].temp);
                            humidity = parseFloat(hours[hour].humidity);
                            dewPoint = CalculateDewPoint(parseFloat(temperature), parseFloat(humidity)).toFixed(3);

                            temperature = temperature.toFixed(1);
                            humidity = humidity.toFixed(1);

                            if (i === 0) {
                                totalMinTemp = temperature;
                                totalMaxTemp = temperature;
                                totalTemperature = temperature;

                                totalMinHumidity = humidity;
                                totalMaxHumidity = humidity;
                                totalHumidity = humidity;

                                totalMinDewPoint = dewPoint;
                                totalMaxDewPoint = dewPoint;
                                totalDewPoint = dewPoint;

                                temperatureHour = humidityHour = dewPointHour = minTempHour = maxTempHour =
                                    minHumidityHour = maxHumidityHour = minDewPointHour = maxDewPointHour =
                                    hour;
                                i++;
                            }

                            minTempHour = temperature < totalMinTemp ? hour : minTempHour;
                            maxTempHour = temperature > totalMaxTemp ? hour : maxTempHour;

                            totalMinTemp = temperature < totalMinTemp ? temperature : totalMinTemp;
                            totalMaxTemp = temperature > totalMaxTemp ? temperature : totalMaxTemp;

                            minHumidityHour = humidity < totalMinHumidity ? hour : minHumidityHour;
                            maxHumidityHour = humidity > totalMaxHumidity ? hour : maxHumidityHour;

                            totalMinHumidity = humidity < totalMinHumidity ? humidity : totalMinHumidity;
                            totalMaxHumidity = humidity > totalMaxHumidity ? humidity : totalMaxHumidity;

                            minDewPointHour = dewPoint < totalMinDewPoint ? hour : minDewPointHour;
                            maxDewPointHour = dewPoint > totalMaxDewPoint ? hour : maxDewPointHour;

                            totalMinDewPoint = dewPoint < totalMinDewPoint ? dewPoint : totalMinDewPoint;
                            totalMaxDewPoint = dewPoint > totalMaxDewPoint ? dewPoint : totalMaxDewPoint;
                            result +=
                             `<tr>
                             <td>${hour}</td>
                             <td>${temperature}</td>
                             <td>${humidity}</td>
                             <td>${dewPoint}</td>
                             </tr>
                             `;
                        }
                    }
                    result +=
                        `</tbody>
                            </table>
                            </div>`;
                    if (data.length > 0) {
                        var cards = [{
                                text: "دمای هوا",
                                value: totalTemperature,
                                unit: "℃",
                                hour: temperatureHour,
                                image: "/image/Temperature.png"
                            },
                            {
                                text: "کمینه دمای هوا",
                                value: totalMinTemp,
                                unit: "℃",
                                hour: minTempHour,
                                image: "/image/Temperature_Min.png"
                            },
                            {
                                text: "بیشینه دمای هوا",
                                value: totalMaxTemp,
                                unit: "℃",
                                hour: maxTempHour,
                                image: "/image/Temperature_Max.png"
                            },
                            {
                                text: "رطوبت",
                                value: totalHumidity,
                                unit: "%",
                                hour: humidityHour,
                                image: "/image/Humidity.png"
                            },
                            {
                                text: "کمینه رطوبت هوا",
                                value: totalMinHumidity,
                                unit: "%",
                                hour: minHumidityHour,
                                image: "/image/Humidity_Min.png"
                            },
                            {
                                text: "بیشینه رطوبت هوا",
                                value: totalMaxHumidity,
                                unit: "%",
                                hour: maxHumidityHour,
                                image: "/image/Humidity_Max.png"
                            },
                            {
                                text: "نقطه شبنم",
                                value: totalDewPoint,
                                unit: "",
                                hour: dewPointHour,
                                image: "/image/DewPoint.png"
                            },
                            {
                                text: "کمینه نقطه شبنم",
                                value: totalMinDewPoint,
                                unit: "",
                                hour: minDewPointHour,
                                image: "/image/DewPoint.png"
                            },
                            {
                                text: "بیشینه نقطه شبنم",
                                value: totalMaxDewPoint,
                                unit: "",
                                hour: maxDewPointHour,
                                image: "/image/DewPoint.png"
                            },
                        ];

                        result += `<div class="row">`;
                        for (var x = 0; x < cards.length; x++) {
                            result +=
                              `
                            <div class="col-sm-4" style="margin-bottom:10px;">
                                <div style="display:flex;justify-content: space-between;background-color:white;border-radius:5px;padding:5px 10px;">
                                    <div>
                                        <p>${cards[x].text}</p>
                                        <p>${cards[x].unit} ${cards[x].value}</p>
                                        <p>${cards[x].hour}</p>
                                    </div>
                                    <img src="${cards[x].image}" style="height:100%" />
                                </div>
                            </div>`;
                        }
                        result += `</div>`;
                    }
                    $("#info").append(result);
                }
            });
        }

    </script>
@endsection
