@extends('layouts.admin', ['pageTitle' => 'گزارش سالانه', 'newButton' => false])
@section('content')
    <script src="/js/selectize.min.js"></script>
    <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />
    <div class="row">
        <div id="content">
            <div class="col-md-3">
                <label for="city_id">ایستگاه</label>
                {!! Form::select('city_id', $customList, null, ['class' => 'form-control', 'id' => 'city_id']) !!}
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>سال:</label>
                    <div class="input-group">
                        <input type="text" style="display: unset;" id="yearWR" class="form-control" placeholder="مثلا:1399">
                        <span class="input-group-addon" style="background-color: aliceblue;display:table-column"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="margin-top: 24px">
                <button class="btn" onclick="report()">جستجو</button>
            </div>
        </div>
        <div style="text-align:center">
            <img src="/image/loading.gif" class="loader" width="64" height="64" style="display:none;margin-top:10px;" />
        </div>
        <div id="report-content"></div>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('select').selectize({
        //         sortField: 'text'
        //     });
        // });
        function report() {
            $("#info").html("");
            $("#report-button").prop("disabled", true);
            $(".loader").css({
                "display": "inline-block"
            });
            var device = $("#city_id").val(),
                date = $("#yearWR").val();
            $.ajax(`getYearlyReport/${device}/${date}`, {
                success: function(response) {
                    // console.log("response", response);
                    var data = response.data;
                    $(".loader").css({
                        "display": "none"
                    });
                    $("#report-button").prop("disabled", false);
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
                        result = `
                                                                                                            <div style="width:100%;text-align:left;">
                                                                                                            <button class="btn btn-success" onclick="exportTableToExcel('report-data', 'گزارش روزانه')"><i class="fa fa-fw fa-file-excel"></i> خروجی اکسل</button>
                                                                                                            </div>
                                                                                                            <br>
                                                                                                            <div class="table-responsive">
                                                                                                            <table class="table table-bordered table-hover" id="report-data">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                            <th>ساعت</th><th>دما</th><th>کمینه دما</th><th>بیشینه دما</th><th>رطوبت</th><th>کمینه رطوبت</th><th>بیشینه رطوبت</th><th>نقطه شبنم</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>`;
                    var items, item, res;
                    if (data.length > 0) {
                        for (var z = 0; z < data.length; z++) {
                            items = data[z].parameters_values.split("!");
                            res = {};
                            for (var k = 0; k < items.length; k++) {
                                item = items[k].split("&");
                                res[item[0]] = item[1];
                            }
                            hours[data[z].SensorFeatureTime] = res;
                        }
                    }

                    var minTemp, maxTemp, temperature, minHumidity, maxHumidity, humidity, dewPoint, i = 0,
                        totalMinTemp, totalMaxTemp, totalTemperature, totalMinHumidity, totalMaxHumidity,
                        totalHumidity, totalMinDewPoint, totalMaxDewPoint, totalDewPoint,
                        minTempHour, maxTempHour, temperatureHour, minHumidityHour, maxHumidityHour,
                        humidityHour, minDewPointHour, maxDewPointHour, dewPointHour;

                    for (const hour in hours) {
                        if (hours[hour]) {
                            minTemp = parseFloat(hours[hour][3]);
                            maxTemp = parseFloat(hours[hour][4]);
                            temperature = (minTemp + maxTemp) / 2;
                            minHumidity = parseFloat(hours[hour][5]);
                            maxHumidity = parseFloat(hours[hour][6]);
                            humidity = (minHumidity + maxHumidity) / 2;
                            dewPoint = CalculateDewPoint(parseFloat(temperature), parseFloat(humidity))
                                .toFixed(
                                    3);

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

                                temperatureHour = humidityHour = dewPointHour = minTempHour = maxTempHour =
                                    minHumidityHour = maxHumidityHour = minDewPointHour = maxDewPointHour =
                                    hour;
                                i++;
                            }

                            minTempHour = minTemp < totalMinTemp ? hour : minTempHour;
                            maxTempHour = maxTemp > totalMaxTemp ? hour : maxTempHour;

                            totalMinTemp = minTemp < totalMinTemp ? minTemp : totalMinTemp;
                            totalMaxTemp = maxTemp > totalMaxTemp ? maxTemp : totalMaxTemp;

                            minHumidityHour = minHumidity < totalMinHumidity ? hour : minHumidityHour;
                            maxHumidityHour = maxHumidity > totalMaxHumidity ? hour : maxHumidityHour;

                            totalMinHumidity = minHumidity < totalMinHumidity ? minHumidity :
                                totalMinHumidity;
                            totalMaxHumidity = maxHumidity > totalMaxHumidity ? maxHumidity :
                                totalMaxHumidity;

                            minDewPointHour = dewPoint < totalMinDewPoint ? hour : minDewPointHour;
                            maxDewPointHour = dewPoint > totalMaxDewPoint ? hour : maxDewPointHour;

                            totalMinDewPoint = dewPoint < totalMinDewPoint ? dewPoint : totalMinDewPoint;
                            totalMaxDewPoint = dewPoint > totalMaxDewPoint ? dewPoint : totalMaxDewPoint;
                            result += `
                                                                                                            <tr>
                                                                                                            <td>${hour}</td><td>${temperature}</td><td>${minTemp}</td><td>${maxTemp}</td><td>${humidity}</td><td>${minHumidity}</td><td>${maxHumidity}</td><td>${dewPoint}</td>
                                                                                                            </tr>
                                                                                                            `;
                        }
                    }
                    result +=
                        `</tbody></table></div>`;



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
