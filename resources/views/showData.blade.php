<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/data/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/data/style.css" />
    <link href="/css/fontawesome-free-5.15.1-web/css/all.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript">
    </script>
    <script src="/js/live-sensor-data.js"></script>
    <script>
        setTopic("987654321");
    </script>
</head>

<body id="home" data-spy="scroll">
    <div id="content">
        <div class="section about_section">
            <div class="container">
                <h4 id="topic" style="text-align:center;padding-bottom:25px;">شناسه دستگاه: 987654321</h4>
                <h5 style="text-align:center;padding-bottom:25px;color:gray;"><span>آخرین بروزرسانی: </span>&nbsp;<span
                        id="last-update"></span></h5>
                <div class="row">
                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                        <div class="feature_box temp">
                            <div class="row">
                                <div class="col-6">
                                    <h4>دمای هوا</h4>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="full icon">
                                        <i class="fas fa-temperature-high fa-5 fa-3dicon" aria-hidden="true"
                                            style="color:orange;font-size:50px"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12" style="text-align:center;">
                                    <h1>
                                        <span id="temp">0</span>&nbsp;<span>&#xb0;C</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                        <div class="feature_box humidity">
                            <div class="row">
                                <div class="col-6">
                                    <h4>رطوبت هوا</h4>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="full icon">
                                        <i class="fas fa-tint" style="color:rgb(18, 200, 224);font-size:50px"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12" style="text-align: center;">
                                    <h1>
                                        <span id="humidity">0</span>&nbsp;<span>%</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                        <div class="feature_box radiation">
                            <div class="row">
                                <div class="col-6">
                                    <h4>شدت تابش</h4>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="full icon">
                                        <i class="fas fa-sun" style="color:rgb(247, 211, 10);font-size:50px"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12" style="text-align: center;">
                                    <h1>
                                        <span id="radiation">0</span><span>W/m²</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                        <div class="feature_box rain">
                            <div class="row">
                                <div class="col-6">
                                    <h4>میزان بارش</h4>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="full icon">
                                        <i class='fas fa-cloud-rain' style="color:blue;font-size:50px"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12" style="text-align: center;">
                                    <h1>
                                        <span id="rain">0</span>&nbsp;<span>mm</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                        <div class="feature_box w_speed">
                            <div class="row">
                                <div class="col-6">
                                    <h4>سرعت باد</h4>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="full icon">
                                        <i class="fas fa-wind" style="color:rgb(47, 179, 231);font-size:50px"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12" style="text-align: center;">
                                    <h1>
                                        <span id="w_speed">0</span>&nbsp;<span>m/s</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6" style="margin-bottom: 20px">
                        <div class="feature_box w_direction">
                            <div class="row">
                                <div class="col-6">
                                    <h4>جهت باد</h4>
                                </div>
                                <div class="col-6">
                                    <br>
                                    <div class="full icon">
                                        <i class="fa fa-compass" style="color:rgb(47, 231, 176);font-size:50px"
                                            aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <h1>
                                        <span id="w_direction">0</span>&nbsp;<span>&#xb0;</span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/custom.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });

    </script>
</body>

</html>
