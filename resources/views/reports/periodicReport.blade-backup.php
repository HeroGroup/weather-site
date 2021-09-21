@extends('layouts.admin', ['pageTitle' => 'گزارش دوره ای', 'newButton' => false])
@section('content')

    <head>
        <meta charset="utf-8" />
        <script src="/js/selectize.min.js"></script>
        <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />

    </head>
    <div class="row" style="margin-bottom: 20px;">
        <div id="content">

            <div class="col-md-3">
                <label for="city_id">ایستگاه</label>
                {!! Form::select('city_id', $customList, null, ['id' => 'city_id', 'class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
                <label for="fromDate">از تاریخ</label>
                <input type="text" name="fromDate" id="fromDate" class="custom_date_picker form-control" />
            </div>
            <div class="col-md-3">
                <label for="toDate">تا تاریخ</label>
                <input type="text" name="toDate" id="toDate" class="custom_date_picker form-control" />
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
            <img src="/image/loading.gif" class="loader" width="110" height="80" style="display:none;" />
        </div>
        <div class="tab-content" id="myTabContent" style="margin-top: 15px">
            <div class="tab-pane active" id="info" role="tabpanel" aria-labelledby="info-tab"></div>
            <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab"></div>
        </div>
    </div>
    <script>
        function jalali_to_gregorian(jy, jm, jd) {
            var sal_a, gy, gm, gd, days;
            jy += 1595;
            days = -355668 + (365 * jy) + (~~(jy / 33) * 8) + ~~(((jy % 33) + 3) / 4) + jd + ((jm < 7) ? (jm - 1) * 31 : ((
                jm - 7) * 30) + 186);
            gy = 400 * ~~(days / 146097);
            days %= 146097;
            if (days > 36524) {
                gy += 100 * ~~(--days / 36524);
                days %= 36524;
                if (days >= 365) days++;
            }
            gy += 4 * ~~(days / 1461);
            days %= 1461;
            if (days > 365) {
                gy += ~~((days - 1) / 365);
                days = (days - 1) % 365;
            }
            gd = days + 1;
            sal_a = [0, 31, ((gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30,
                31, 30, 31
            ];
            for (gm = 0; gm < 13 && gd > sal_a[gm]; gm++) gd -= sal_a[gm];
            return [gy, gm, gd];
        }

        function gregorian_to_jalali(gy, gm, gd) {
            var g_d_m, jy, jm, jd, gy2, days;
            g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            gy2 = (gm > 2) ? (gy + 1) : gy;
            days = 355666 + (365 * gy) + ~~((gy2 + 3) / 4) - ~~((gy2 + 99) / 100) + ~~((gy2 + 399) / 400) + gd + g_d_m[gm -
                1];
            jy = -1595 + (33 * ~~(days / 12053));
            days %= 12053;
            jy += 4 * ~~(days / 1461);
            days %= 1461;
            if (days > 365) {
                jy += ~~((days - 1) / 365);
                days = (days - 1) % 365;
            }
            if (days < 186) {
                jm = 1 + ~~(days / 31);
                jd = 1 + (days % 31);
            } else {
                jm = 7 + ~~((days - 186) / 30);
                jd = 1 + ((days - 186) % 30);
            }
            return [jy, jm, jd];
        }

        var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g],
            arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];

        function fixNumbers(str) {
            if (typeof str === 'string')
                for (var i = 0; i < 10; i++)
                    str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);

            return str;
        };

        $(document).ready(function() {
            $('select').selectize({
                sortField: 'text'
            });
        });

        function report() {
            $("#info").html("");
            $("#report-button").prop("disabled", true);
            $(".loader").css({
                "display": "inline-block"
            });
            var device = $("#city_id").val(),
                dateFirst = $("#fromDate").val(),
                dateSecond = $("#toDate").val();

            //***********************Split date*******************************

            var startDate = dateFirst.split('-');
            var endDate = dateSecond.split('-');
            // console.log(startDate);

            var year = startDate[0],
                month = startDate[1],
                day = startDate[2];

            var yearEnd = endDate[0],
                monthEnd = endDate[1],
                dayEnd = endDate[2];

            year = fixNumbers(year);
            month = fixNumbers(month);
            day = fixNumbers(day);

            yearEnd = fixNumbers(yearEnd);
            monthEnd = fixNumbers(monthEnd);
            dayEnd = fixNumbers(dayEnd);

            startDate = jalali_to_gregorian(parseInt(year), parseInt(month), parseInt(day));
            endDate = jalali_to_gregorian(parseInt(yearEnd), parseInt(monthEnd), parseInt(dayEnd));


            //********************Diff Date***********************************
            var date1 = new Date(startDate);
            var date2 = new Date(endDate);

            // To calculate the time difference of two dates 
            var Difference_In_Time = date2.getTime() - date1.getTime();

            // To calculate the no. of days between two dates 
            var Difference_In_Days = (Difference_In_Time / (1000 * 3600 * 24)) + 1;

            //***********************use date from firstMode**************************
            var firstDay = dateFirst.split('-');
            var secondDay = dateSecond.split('-');
            // console.log(firstDay);

            var newDate = new Date(startDate);
            newDate.setDate(newDate.getDate() + 1);
            var month = newDate.getUTCMonth() + 1; //months from 1-12
            var day = newDate.getUTCDate();
            var year = newDate.getUTCFullYear();

            // console.log(newDate);
            // const monthRollsOver = addDays(myDate, 31);

            // newDate = startDate + Difference_In_Days;

            var formattedDate = `${newDate.getFullYear()}-${(newDate.getMonth() + 1)}-${newDate.getDate()}`;
            var daysOfYear = [];
            for (newDate; newDate <= Difference_In_Days; newDate.setDate(newDate.getDate() + 2)) {
                daysOfYear.push(newDate);
            }
            formattedDate = gregorian_to_jalali(newDate.getFullYear(), (newDate.getMonth() + 1), newDate.getDate());
            // console.log(formattedDate);
            //console.log(daysOfYear);
            //*******************************************************
            $.ajax(`getperiodicReport/${device}/${dateFirst}/${dateSecond}`, {
                success: function(response) {
                    console.log("response", response);
                    var data = response.data;
                    $(".loader").css({
                        "display": "none"
                    });
                    $("#report-button").prop("disabled", false);
                    var hours = {

                    };
                    var result =
                        `<div class="table-responsive"><table class="table table-bordered table-hover"><thead><tr><th>روز</th><th>دما</th><th>رطوبت</th><th>نقطه شبنم</th></tr></thead><tbody>`;
                    var items, item, res;
                    if (data.length > 0) {
                        for (var z = 0; z < data.length; z++) {
                            items = data[z].parameters_values.split("!");
                            res = {};
                            for (var k = 0; k <
                                items.length; k++) {
                                item = items[k].split("&");
                                res[item[0]] = item[1];
                            }
                            // console.log(data[z].SensorDate,res); // hours[data[z].SensorFeatureTime]=res; } } for (hour in hours) { var minTemp='-' , maxTemp='-' ,
                            temperature = '-', minHumidity = '-', maxHumidity = '-', humidity = '-', dewPoint =
                                '-';
                            if (hours[hour]) {
                                minTemp = parseFloat(hours[hour][3]);
                                maxTemp = parseFloat(hours[hour][4]);
                                temperature = ((minTemp + maxTemp) /
                                    2).toFixed(1);
                                minHumidity = parseFloat(hours[hour][5]);
                                maxHumidity = parseFloat(hours[hour][6]);
                                humidity = ((minHumidity + maxHumidity) / 2).toFixed(1);
                                dewPoint = (temperature - ((100 - humidity) /
                                    5)).toFixed(1);
                            }
                            result +=
                                `<tr><td>${hour}</td><td>${temperature}</td><td>${humidity}</td><td>${dewPoint}</td></tr>`;
                        } // end loop on hours
                        result += `</tbody></table></div>`;
                    }
                    $("#info").append(result);
                } // end success
            }); // end ajax
        } // end function

    </script>

@endsection
