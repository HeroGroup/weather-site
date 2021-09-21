@extends('layouts.admin', ['pageTitle' => 'گزارش ساعتی', 'newButton' => false])
@section('content')
    <style>
        td {
            direction: ltr;
        }

        p {
            margin: 0;
        }

    </style>

    <div class="row">
        <div id="content">

            <div class="col-md-3">
                <label for="city_id">انتخاب ایستگاه</label>
                {!! Form::select('city_id', $customList, null, ['class' => 'form-control', 'id' => 'city_id']) !!}
            </div>
            <div class="col-md-3">
                <label for="from">از تاریخ</label>
                <input type="text" name="from" id="from" class="custom_date_picker form-control" />
            </div>
            <div class="col-md-3">
                <label for="to">تا تاریخ</label>
                <input type="text" name="to" id="to" class="custom_date_picker form-control" />
            </div>
            <div class="col-md-3" style="margin-top: 24px">
                <button class="btn" id="report-button" onclick="report()">جستجو</button>
            </div>

        </div>
    </div>

    <div style="text-align:center">
        <img src="/image/loading.gif" class="loader" width="64" height="64" style="display:none;margin-top:10px;" />
    </div>

    <div id="report-content"></div>

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
                        children += `<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse${iterator}">${dtt}</a>
                                    </h4>
                                </div>
                                <div id="collapse${iterator}" class="panel-collapse collapse in">
                                    <div class="panel-body">`;
                        children += showDataInHours(result[property]);
                        children += `</div></div></div>`;
                    }

                    children += `</div>`;
                    $("#report-content").append(children);
                }
            });
        }

        function showDataInHours(input) {
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
                result = `<div class="table-responsive">
                                      <table class="table table-bordered table-hover">
                                          <thead>
                                              <tr>
                                                  <th>ساعت</th>
                                                  <th>دما</th>
                                                  <th>کمینه دما</th>
                                                  <th>بیشینه دما</th>
                                                  <th>رطوبت</th>
                                                  <th>کمینه رطوبت</th>
                                                  <th>بیشینه رطوبت</th>
                                                  <th>نقطه شبنم</th>
                                              </tr>
                                          </thead>
                                      <tbody>`;

            var items, item, res;
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
                minTempHour, maxTempHour, temperatureHour, minHumidityHour, maxHumidityHour, humidityHour, minDewPointHour,
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
                    result += `<tr>
                        <td>${hour}</td>
                        <td>${temperature}</td>
                        <td>${minTemp}</td>
                        <td>${maxTemp}</td>
                        <td>${humidity}</td>
                        <td>${minHumidity}</td>
                        <td>${maxHumidity}</td>
                        <td>${dewPoint}</td>
                        </tr>`;
                }
            }
            result += `</tbody></table></div>`;

            // جدول پایین

            result += `<div class="table-responsive">
                               <table class="table">
                                   <thead>
                                       <tr>
                                           <th>بیشینه مطلق دما</th>
                                           <th>کمینه مطلق دما</th>
                                           <th>دما</th>
                                           <th>بیشینه مطلق رطوبت</th>
                                           <th>کمینه مطلق رطوبت</th>
                                           <th>رطوبت</th>
                                           <th>ب.نقطه شبنم</th>
                                    <th>ک.نقطه شبنم</th>
                                    <th>نقطه شبنم</th>
                                </tr>
                            </thead>
                                         <tbody>
                                             <tr>
                                 <td>${totalMaxTemp}</td>
                                 <td>${totalMinTemp}</td>
                                 <td>${totalTemperature}</td>
                                 <td>${totalMaxHumidity}</td>
                                 <td>${totalMinHumidity}</td>
                                 <td>${totalHumidity}</td>
                                 <td>${totalMaxDewPoint}</td>
                                 <td>${totalMinDewPoint}</td>
                                 <td>${totalDewPoint}</td>
                             </tr>
                       </tbody>
                                  </table>
                              </div>`;

            return result;
        }

    </script>
@endsection
