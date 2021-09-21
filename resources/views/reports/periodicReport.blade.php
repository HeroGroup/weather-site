@extends('layouts.admin', ['pageTitle' => 'گزارش دوره ای', 'newButton' => false])
@section('content')

    <head>
        <meta charset="utf-8" />
        <script src="/js/selectize.min.js"></script>
        <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />
        <style>
            td {
                direction: ltr;
            }

            p {
                margin: 0;
            }

        </style>

    </head>
    <div class="row" style="margin-bottom: 20px;">
        <div id="content">
            <div class="col-md-3">
                <label for="city_id">ایستگاه</label>
                {!! Form::select('city_id', $customList, null, ['id' => 'city_id', 'class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                <label for="fromDate">از تاریخ</label>
                <input type="text" name="fromDate" id="from" class="custom_date_picker form-control" />
            </div>
            <div class="col-md-3">
                <label for="toDate">تا تاریخ</label>
                <input type="text" name="toDate" id="to" class="custom_date_picker form-control" />
            </div>
            <div class="col-md-3" style="margin-top: 24px">
                <button class="btn" id="report-button" onclick="report()">جستجو</button>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="info-tab" style="border: 2px solid aliceblue;color:black" data-toggle="tab"
                    href="#info" role="tab" aria-controls="info" aria-selected="false">نمایش اطلاعات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="chart-tab" style="border: 2px solid aliceblue;color:black" data-toggle="tab"
                    href="#chart" role="tab" aria-controls="chart" aria-selected="false">نمودار</a>
            </li>
        </ul>
        <div style="text-align:center">
            <img src="/image/loading.gif" class="loader" width="64" height="64" style="display:none;margin-top:10px;" />
        </div>
        <div class="tab-content" id="myTabContent" style="margin-top: 15px">
            <div class="tab-pane active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <div id="report-content"></div>
            </div>
            <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab"></div>
        </div>
    </div>

    <script src="/js/export-to-excel.js"></script>
    <script src="/js/helpers.js"></script>
    <script>
        function report() {
            // console.log($("#city_id").val(), $("#from").val(), $("#to").val());
            var device = $("#city_id").val(),
                fromDate = $("#from").val(),
                toDate = $("#to").val();
            $("#report-content").html("");
            $("#report-button").prop("disabled", true);
            $(".loader").css({
                "display": "inline-block"
            });
            $.ajax(`getHourlyReport/${device}/${fromDate}/${toDate}`, {
                success: function(response) {
                    // console.log("response", response);
                    var data = response.data;
                    $(".loader").css({
                        "display": "none"
                    });
                    $("#report-button").prop("disabled", false);

                    var result = {};
                    for (const index in data) {
                        if (result[[data[index].SensorFeatureDate]]) {
                            result[[data[index].SensorFeatureDate]].push(data[index]);
                        } else {
                            result[[data[index].SensorFeatureDate]] = [data[index]];
                        }
                    }

                    var children = `<div class="panel-group" id="accordion" style="margin-bottom: 80px;">`;
                    var iterator = 0;
                    for (const property in result) {
                        iterator++;
                        var d = property.split('-');
                        var dt = gregorian_to_jalali(Number(d[0]), Number(d[1]), Number(d[2]));
                        var dtt = dt.join('/');
                        children +=
                            `<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse${iterator}">${dtt}</a></h4></div><div id="collapse${iterator}" class="panel-collapse collapse in"><div class="panel-body">`;
                        children += showDataInHours(dtt, result[property]);
                        children += `</div></div></div>`;
                    }

                    children += `</div>`;
                    $("#report-content").append(children);
                }
            });
        }

        function showDataInHours(inputDate, input) {
            var hours = {
                    "23:30": "",
                    "23:00": "",
                    "22:30": "",
                    "22:00": "",
                    "21:30": "",
                    "21:00": "",
                    "20:30": "",
                    "20:00": "",
                    "19:30": "",
                    "19:00": "",
                    "18:30": "",
                    "18:00": "",
                    "17:30": "",
                    "17:00": "",
                    "16:30": "",
                    "16:00": "",
                    "15:30": "",
                    "15:00": "",
                    "14:30": "",
                    "14:00": "",
                    "13:30": "",
                    "13:00": "",
                    "12:30": "",
                    "12:00": "",
                    "11:30": "",
                    "11:00": "",
                    "10:30": "",
                    "10:00": "",
                    "09:30": "",
                    "09:00": "",
                    "08:30": "",
                    "08:00": "",
                    "07:30": "",
                    "07:00": "",
                    "06:30": "",
                    "06:00": "",
                    "05:30": "",
                    "05:00": "",
                    "04:30": "",
                    "04:00": "",
                    "03:30": "",
                    "03:00": "",
                    "02:30": "",
                    "02:00": "",
                    "01:30": "",
                    "01:00": "",
                    "00:30": "",
                    "00:00": ""
                },

                result = ``;
            var items, item, res, result;
            if (input.length > 0) {
                for (var z = 0; z < input.length; z++) {
                    items = input[z].parameters_values.split("!");
                    res = {};
                    for (var k = 0; k < items.length; k++) {
                        item = items[k].split("&");
                        res[item[0]] = item[1];
                    }
                    hours[input[z].SensorFeatureTime] = res;
                }
            }

            var minTemp, maxTemp, temperature, minHumidity, maxHumidity, humidity, dewPoint, i = 0,
                totalMinTemp, totalMaxTemp, totalTemperature, totalMinHumidity, totalMaxHumidity, totalHumidity,
                totalMinDewPoint, totalMaxDewPoint, totalDewPoint,
                minTempHour, maxTempHour, temperatureHour, minHumidityHour, maxHumidityHour, humidityHour,
                minDewPointHour,
                maxDewPointHour, dewPointHour;

            for (const hour in hours) {
                if (hours[hour]) {
                    minTemp = parseFloat(hours[hour][3]);
                    maxTemp = parseFloat(hours[hour][4]);
                    temperature = (minTemp + maxTemp) / 2;
                    minHumidity = parseFloat(hours[hour][5]);
                    maxHumidity = parseFloat(hours[hour][6]);
                    humidity = (minHumidity + maxHumidity) / 2;
                    dewPoint = CalculateDewPoint(parseFloat(temperature), parseFloat(humidity)).toFixed(3);

                    temperature = temperature.toFixed(1);
                    humidity = humidity.toFixed(1);

                    if (i === 0) {
                        totalMinTemp = minTemp;
                        totalMaxTemp = maxTemp;
                        totalTemperature = temperature;

                        totalMinHumidity = minHumidity;
                        totalMaxHumidity = maxHumidity;
                        totalHumidity = humidity;

                        totalMinDewPoint = dewPoint;
                        totalMaxDewPoint = dewPoint;
                        totalDewPoint = dewPoint;

                        temperatureHour = humidityHour = dewPointHour = minTempHour = maxTempHour = minHumidityHour =
                            maxHumidityHour = minDewPointHour = maxDewPointHour = hour;
                        i++;
                    }

                    minTempHour = minTemp < totalMinTemp ? hour : minTempHour;
                    maxTempHour = maxTemp > totalMaxTemp ? hour : maxTempHour;

                    totalMinTemp = minTemp < totalMinTemp ? minTemp : totalMinTemp;
                    totalMaxTemp = maxTemp > totalMaxTemp ? maxTemp : totalMaxTemp;

                    minHumidityHour = minHumidity < totalMinHumidity ? hour : minHumidityHour;
                    maxHumidityHour = maxHumidity > totalMaxHumidity ? hour : maxHumidityHour;

                    totalMinHumidity = minHumidity < totalMinHumidity ? minHumidity : totalMinHumidity;
                    totalMaxHumidity = maxHumidity > totalMaxHumidity ? maxHumidity : totalMaxHumidity;

                    minDewPointHour = dewPoint < totalMinDewPoint ? hour : minDewPointHour;
                    maxDewPointHour = dewPoint > totalMaxDewPoint ? hour : maxDewPointHour;

                    totalMinDewPoint = dewPoint < totalMinDewPoint ? dewPoint : totalMinDewPoint;
                    totalMaxDewPoint = dewPoint > totalMaxDewPoint ? dewPoint : totalMaxDewPoint;

                    result += ``;

                }
            }
            result += ``;

            result +=
                `<div style="width:100%;text-align:left;"><button class="btn btn-success" onclick="exportTableToExcel('report-data', 'گزارش دوره ای')"><i class="fa fa-fw fa-file-excel"></i> خروجی اکسل</button></div><br><div class="table-responsive"><table class="table table-bordered table-hover" id="report-data"><thead><tr><th>بیشینه مطلق دما</th><th>کمینه مطلق دما</th><th>دما</th><th>بیشینه مطلق رطوبت</th><th>کمینه مطلق رطوبت</th><th>رطوبت</th><th>ب.نقطه شبنم</th><th>ک.نقطه شبنم</th><th>نقطه شبنم</th></tr></thead><tbody><tr><td>${totalMaxTemp}</td><td>${totalMinTemp}</td><td>${totalTemperature}</td><td>${totalMaxHumidity}</td><td>${totalMinHumidity}</td><td>${totalHumidity}</td><td>${totalMaxDewPoint}</td><td>${totalMinDewPoint}</td><td>${totalDewPoint}</td></tr></tbody></table></div>`;
            return result;
        }

    </script>

@endsection
