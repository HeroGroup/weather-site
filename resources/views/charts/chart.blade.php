@extends('layouts.admin', ['pageTitle' => 'نمودار ایستگاه '.$Result[0]->device_code,'icon'=>'fa fa-line-chart', 'newButton' => false])
@section('content')
    <!DOCTYPE HTML>
    <html>

    <head>
        <style>
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
        <script src="/js/helpers.js"></script>
        <script src="/js/live-sensor-data.js"></script>
        <script>
            const names = {
                "temp": "دما در 24 ساعت گذشته",
                "humidity": "رطوبت در 24 ساعت گذشته",
                "soil": "رطوبت خاک در 24 ساعت گذشته",
                "w_speed": "سرعت باد در 24 ساعت گذشته",
                "w_direction": "جهت باد در 24 ساعت گذشته",
                "radiation": "رطوبت خاک در 24 ساعت گذشته",
                "rain": "میزان بارش در 24 ساعت گذشته",
            };
            window.onload = function() {
                var station = "{{ $station }}",
                    param = "{{ $param }}",
                    result = [];



                $.ajax(`/admin/getChartData/${station}`, {
                    success: function(response) {
                        var data = response.data;
                        for (var i = 0; i < data.length; i++) {
                            var dateTime = new Date(data[i].date_time.replace(" ","T"));
                            var z = data[i].date_time.substr(11, 5);
                            // console.log(z);
                            result.push({
                                x: dateTime, //data[i].date_time.substr(11, 5),
                                y: parseFloat(JSON.parse(data[i].parameters_values)[param]),
                                z:z
                            });
                        }
                        // console.log(result);

                        var chart = new CanvasJS.Chart("chartContainer", {
                            animationEnabled: true,
                            // animationDuration: 2000,
                            theme: "light1",
                            backgroundColor: "#F5DEB3",
                            dataPointWidth: 40,
                            title: {
                                text: `نمودار ${names[param]}`,
                                fontFamily: "IRANSans",
                            },
                            toolTip:{
                                content: "{z}, {y}"
                              },

                             axisX: {
                                 valueFormatString: "HH:mm",
                            //     scaleBreaks: {
		                    //         	autoCalculate: true,
		                    //         	type: "wavy",
                            //             color: "green"
		                    //                  }
                             },

                            data: [{
                                type: "line",
                                dataPoints: result
                            }]
                        });
                        chart.render();
                    }
                });
               // ********************************************************************************

                    var device=station;

                    var today = new Date();
                    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    console.log(date);

                    // $("#info").html("");
                    var indx=[param];
                    console.log(indx);

                $.ajax(`/admin/getChartReport/${device}/${date}`,{
                    success: function(response){
                        var data=response.data;
                        var hours = {},result="";

                    if (data.length > 0) {
                        for (var z = 0; z < data.length; z++) {
                            hours[data[z].SensorFeatureTime] = JSON.parse(data[z].parameters_values);
                                                              }
                                         }
                      var minTemp, maxTemp, temperature, minHumidity, maxHumidity, humidity, dewPoint, i = 0,
                        totalMinTemp, totalMaxTemp, totalTemperature, totalMinHumidity, totalMaxHumidity,
                        totalHumidity, totalMinDewPoint, totalMaxDewPoint, totalDewPoint,
                        minTempHour, maxTempHour, temperatureHour, minHumidityHour, maxHumidityHour,
                        humidityHour, minDewPointHour, maxDewPointHour, dewPointHour;

                        for (const hour in hours) {
                        if (hours[hour]) {
                            temperature = parseFloat(hours[hour].temp);
                            humidity = parseFloat(hours[hour].humidity);
                            dewPoint =CalculateDewPoint(parseFloat(temperature), parseFloat(humidity)).toFixed(3);
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

                        }
                    }
                         result +=
                        `</tbody>
                            </table>
                            </div>`;
                    if (data.length > 0 && indx=="temp") {
                        var cards = [
                            {
                                text: "کمینه دمای هوا",
                                value: totalMinTemp,
                                unit: "℃",
                                hour: minTempHour,
                                image: "/image/down-arrow-64.png"
                            },
                            {
                                text: "بیشینه دمای هوا",
                                value: totalMaxTemp,
                                unit: "℃",
                                hour: maxTempHour,
                                image: "/image/up-arrow-64.png"
                            }
                        ];

                        result += `<div class="row">`;
                        for (var x = 0; x < cards.length; x++) {
                            result +=
                              `
                            <div class="col-sm-4" style="margin-bottom:10px;">
                                <div style="display:flex;justify-content: space-between;background-color: beige;border-radius: 5px;padding:5px 10px;">
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
                    else if(data.length >0 && indx=="humidity"){
                         var cards = [
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
                            }
                        ];
                                  result += `<div class="row">`;
                        for (var x = 0; x < cards.length; x++) {
                            result +=
                              `
                            <div class="col-sm-4" style="margin-bottom:10px;">
                                <div style="display:flex;justify-content: space-between;background-color: beige;border-radius: 5px;padding:5px 10px;">
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
                    //  else if(data.length >0 && indx=="humidity"){
                    //      var cards = [
                    //         {
                    //             text: "کمینه دمای هوا",
                    //             value: totalMinTemp,
                    //             unit: "℃",
                    //             hour: minTempHour,
                    //             image: "/image/down-arrow-64.png"
                    //         },
                    //         {
                    //             text: "بیشینه دمای هوا",
                    //             value: totalMaxTemp,
                    //             unit: "℃",
                    //             hour: maxTempHour,
                    //             image: "/image/up-arrow-64.png"
                    //         },
                    //         {
                    //             text: "رطوبت",
                    //             value: totalHumidity,
                    //             unit: "%",
                    //             hour: humidityHour,
                    //             image: "/image/Humidity.png"
                    //         },
                    //         {
                    //             text: "کمینه رطوبت هوا",
                    //             value: totalMinHumidity,
                    //             unit: "%",
                    //             hour: minHumidityHour,
                    //             image: "/image/Humidity_Min.png"
                    //         },
                    //         {
                    //             text: "بیشینه رطوبت هوا",
                    //             value: totalMaxHumidity,
                    //             unit: "%",
                    //             hour: maxHumidityHour,
                    //             image: "/image/Humidity_Max.png"
                    //         },
                    //         {
                    //             text: "نقطه شبنم",
                    //             value: totalDewPoint,
                    //             unit: "",
                    //             hour: dewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "کمینه نقطه شبنم",
                    //             value: totalMinDewPoint,
                    //             unit: "",
                    //             hour: minDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "بیشینه نقطه شبنم",
                    //             value: totalMaxDewPoint,
                    //             unit: "",
                    //             hour: maxDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //     ];

                    //     result += `<div class="row">`;
                    //     for (var x = 0; x < cards.length; x++) {
                    //         result +=
                    //           `
                    //         <div class="col-sm-4" style="margin-bottom:10px;">
                    //             <div style="display:flex;justify-content: space-between;background-color: beige;border-radius: 5px;padding:5px 10px;">
                    //                 <div>
                    //                     <p>${cards[x].text}</p>
                    //                     <p>${cards[x].unit} ${cards[x].value}</p>
                    //                     <p>${cards[x].hour}</p>
                    //                 </div>
                    //                 <img src="${cards[x].image}" style="height:100%" />
                    //             </div>
                    //         </div>`;
                    //                                             }
                    //     result += `</div>`;
                    // }
                    //  else if(data.length >0 && indx=="humidity"){
                    //     var cards = [
                    //         {
                    //             text: "کمینه دمای هوا",
                    //             value: totalMinTemp,
                    //             unit: "℃",
                    //             hour: minTempHour,
                    //             image: "/image/down-arrow-64.png"
                    //         },
                    //         {
                    //             text: "بیشینه دمای هوا",
                    //             value: totalMaxTemp,
                    //             unit: "℃",
                    //             hour: maxTempHour,
                    //             image: "/image/up-arrow-64.png"
                    //         },
                    //         {
                    //             text: "رطوبت",
                    //             value: totalHumidity,
                    //             unit: "%",
                    //             hour: humidityHour,
                    //             image: "/image/Humidity.png"
                    //         },
                    //         {
                    //             text: "کمینه رطوبت هوا",
                    //             value: totalMinHumidity,
                    //             unit: "%",
                    //             hour: minHumidityHour,
                    //             image: "/image/Humidity_Min.png"
                    //         },
                    //         {
                    //             text: "بیشینه رطوبت هوا",
                    //             value: totalMaxHumidity,
                    //             unit: "%",
                    //             hour: maxHumidityHour,
                    //             image: "/image/Humidity_Max.png"
                    //         },
                    //         {
                    //             text: "نقطه شبنم",
                    //             value: totalDewPoint,
                    //             unit: "",
                    //             hour: dewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "کمینه نقطه شبنم",
                    //             value: totalMinDewPoint,
                    //             unit: "",
                    //             hour: minDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "بیشینه نقطه شبنم",
                    //             value: totalMaxDewPoint,
                    //             unit: "",
                    //             hour: maxDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //     ];

                    //     result += `<div class="row">`;
                    //     for (var x = 0; x < cards.length; x++) {
                    //         result +=
                    //           `
                    //         <div class="col-sm-4" style="margin-bottom:10px;">
                    //             <div style="display:flex;justify-content: space-between;background-color: beige;border-radius: 5px;padding:5px 10px;">
                    //                 <div>
                    //                     <p>${cards[x].text}</p>
                    //                     <p>${cards[x].unit} ${cards[x].value}</p>
                    //                     <p>${cards[x].hour}</p>
                    //                 </div>
                    //                 <img src="${cards[x].image}" style="height:100%" />
                    //             </div>
                    //         </div>`;
                    //                                             }
                    //     result += `</div>`;
                    // }
                    //  else if(data.length >0 && indx=="humidity"){
                    //      var cards = [
                    //         {
                    //             text: "کمینه دمای هوا",
                    //             value: totalMinTemp,
                    //             unit: "℃",
                    //             hour: minTempHour,
                    //             image: "/image/down-arrow-64.png"
                    //         },
                    //         {
                    //             text: "بیشینه دمای هوا",
                    //             value: totalMaxTemp,
                    //             unit: "℃",
                    //             hour: maxTempHour,
                    //             image: "/image/up-arrow-64.png"
                    //         },
                    //         {
                    //             text: "رطوبت",
                    //             value: totalHumidity,
                    //             unit: "%",
                    //             hour: humidityHour,
                    //             image: "/image/Humidity.png"
                    //         },
                    //         {
                    //             text: "کمینه رطوبت هوا",
                    //             value: totalMinHumidity,
                    //             unit: "%",
                    //             hour: minHumidityHour,
                    //             image: "/image/Humidity_Min.png"
                    //         },
                    //         {
                    //             text: "بیشینه رطوبت هوا",
                    //             value: totalMaxHumidity,
                    //             unit: "%",
                    //             hour: maxHumidityHour,
                    //             image: "/image/Humidity_Max.png"
                    //         },
                    //         {
                    //             text: "نقطه شبنم",
                    //             value: totalDewPoint,
                    //             unit: "",
                    //             hour: dewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "کمینه نقطه شبنم",
                    //             value: totalMinDewPoint,
                    //             unit: "",
                    //             hour: minDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "بیشینه نقطه شبنم",
                    //             value: totalMaxDewPoint,
                    //             unit: "",
                    //             hour: maxDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //     ];

                    //     result += `<div class="row">`;
                    //     for (var x = 0; x < cards.length; x++) {
                    //         result +=
                    //           `
                    //         <div class="col-sm-4" style="margin-bottom:10px;">
                    //             <div style="display:flex;justify-content: space-between;background-color: beige;border-radius: 5px;padding:5px 10px;">
                    //                 <div>
                    //                     <p>${cards[x].text}</p>
                    //                     <p>${cards[x].unit} ${cards[x].value}</p>
                    //                     <p>${cards[x].hour}</p>
                    //                 </div>
                    //                 <img src="${cards[x].image}" style="height:100%" />
                    //             </div>
                    //         </div>`;
                    //                                             }
                    //     result += `</div>`;
                    // }
                    //  else if(data.length >0 && indx=="humidity"){
                    //      var cards = [
                    //         {
                    //             text: "کمینه دمای هوا",
                    //             value: totalMinTemp,
                    //             unit: "℃",
                    //             hour: minTempHour,
                    //             image: "/image/down-arrow-64.png"
                    //         },
                    //         {
                    //             text: "بیشینه دمای هوا",
                    //             value: totalMaxTemp,
                    //             unit: "℃",
                    //             hour: maxTempHour,
                    //             image: "/image/up-arrow-64.png"
                    //         },
                    //         {
                    //             text: "رطوبت",
                    //             value: totalHumidity,
                    //             unit: "%",
                    //             hour: humidityHour,
                    //             image: "/image/Humidity.png"
                    //         },
                    //         {
                    //             text: "کمینه رطوبت هوا",
                    //             value: totalMinHumidity,
                    //             unit: "%",
                    //             hour: minHumidityHour,
                    //             image: "/image/Humidity_Min.png"
                    //         },
                    //         {
                    //             text: "بیشینه رطوبت هوا",
                    //             value: totalMaxHumidity,
                    //             unit: "%",
                    //             hour: maxHumidityHour,
                    //             image: "/image/Humidity_Max.png"
                    //         },
                    //         {
                    //             text: "نقطه شبنم",
                    //             value: totalDewPoint,
                    //             unit: "",
                    //             hour: dewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "کمینه نقطه شبنم",
                    //             value: totalMinDewPoint,
                    //             unit: "",
                    //             hour: minDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //         {
                    //             text: "بیشینه نقطه شبنم",
                    //             value: totalMaxDewPoint,
                    //             unit: "",
                    //             hour: maxDewPointHour,
                    //             image: "/image/DewPoint.png"
                    //         },
                    //     ];

                    //     result += `<div class="row">`;
                    //     for (var x = 0; x < cards.length; x++) {
                    //         result +=
                    //           `
                    //         <div class="col-sm-4" style="margin-bottom:10px;">
                    //             <div style="display:flex;justify-content: space-between;background-color: beige;border-radius: 5px;padding:5px 10px;">
                    //                 <div>
                    //                     <p>${cards[x].text}</p>
                    //                     <p>${cards[x].unit} ${cards[x].value}</p>
                    //                     <p>${cards[x].hour}</p>
                    //                 </div>
                    //                 <img src="${cards[x].image}" style="height:100%" />
                    //             </div>
                    //         </div>`;
                    //                                             }
                    //     result += `</div>`;
                    // }
                    $("#info").append(result);
                    }
                });
            }
        </script>
    </head>

    <body>
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <br>
        <script src="/js/canvasjs.min.js"></script>
        <div class="row">
            <div id="info" style="margin-top:50px;"></div>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-default button" style="margin: 10px"><span>بازگشت به صفحه
                قبل</span></a>

    </body>

    </html>
@endsection
