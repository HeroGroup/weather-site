<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">
<div id="app" style="width:100%;height:600px;"></div>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.env.js"></script>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.min.js"></script>
<style>
    .mapp-container .popup-header {
        font-size: 1.5rem;
        color: #f7280c;
        line-height: 2rem;
        text-align: center
    }

</style>
<script>
    $(document).ready(function() {
        var app = new Mapp({
            element: '#app',
            presets: {
                latlng: {
                    lat: 29.6117,
                    lng: 52.5228,
                },
                zoom: 7,
            },
            i18n: {
                fa: {
                    'marker-title': 'عنوان',
                    // 'marker-description': 'توضیح',
                },
                //   en: {
                //     'marker-title': 'Title',
                //     'marker-description': 'Description',
                //   }
            },
            apiKey: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZiODg3ZmNlOGJkOTI5M2I5NGEwM2I1NzA1Yzk5YmY0YTYyM2I3M2FjODViZDViMTY3NjA4MjY3YmM1MDBlOTMwNGQ3OTgzNDg4MzAyN2Q4In0.eyJhdWQiOiIxMjA3NCIsImp0aSI6ImZiODg3ZmNlOGJkOTI5M2I5NGEwM2I1NzA1Yzk5YmY0YTYyM2I3M2FjODViZDViMTY3NjA4MjY3YmM1MDBlOTMwNGQ3OTgzNDg4MzAyN2Q4IiwiaWF0IjoxNjA5MDYxMjgyLCJuYmYiOjE2MDkwNjEyODIsImV4cCI6MTYxMTU2Njg4Miwic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.WMI68GJPBB1lrBSpHVgZo02Jahe_1p6wbzvuEpEcpU8bciuPiJg2OoPNbzJWHYSFT2RxvdsM5dq5oUOfKVKmKmIdtyPoH8s0ujmU_ZxRGLrDRzFUTSxVE3aQvxYQGVUXpQvcWi_RilRy9TKr2z6sgNSgAMiBo8jpbj7wAjxvEZZsLmhZFu9Ty9bwV3yHKITIUtZu-yc07JNWQcw4OkgBmc_NvRnnd8oIhDpjo99T4feNvCZbXGbj0hwNEvLl-55fThJEnk6d_9-UQbvl-6_MRoN3stlQndCXM5r4PBAL1Zn5Z5y4RSIlwLDH1ScIhC0RJe6W6OMfrbKNaFqXc_kRPg'
        });
        app.addLayers();

        markers = [{
                name: "marker1",
                lat: 29.6117,
                lng: 52.5228,
                color: app.icons.red,
                title: 'شیراز'
            }, {
                name: "marker2",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.green,
                title: 'تست سازمان هواشناسی'
            }, {
                name: "marker3",
                lat: 29.5873,
                lng: 52.5709,
                color: app.icons.red,
                title: 'محوطه کارخانه'
            }, {
                name: "marker4",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.green,
                title: 'سیاخ دارنگون'
            },
            {
                name: "marker5",
                lat: 29.4294,
                lng: 53.2260,
                color: app.icons.red,
                title: 'خرامه'
            },
            {
                name: "marker6",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.green,
                title: 'همایجان'
            },
            {
                name: "marker7",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.green,
                title: 'ایج'
            },
            {
                name: "marker8",
                lat: 27.6253,
                lng: 52.9965,
                color: app.icons.red,
                title: 'علامرودشت'
            },
            {
                name: "marker9",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.green,
                title: 'کمهر'
            },
            {
                name: "marker10",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.red,
                title: 'فتح آباد'
            },
            {
                name: "marker11",
                lat: 29.6321,
                lng: 52.5427,
                color: app.icons.green,
                title: 'ارسنجان'
            },
            {
                name: "marker12",
                lat: 29.7578,
                lng: 51.97,
                color: app.icons.red,
                title: 'زنگنه'
            },
            {
                name: "marker13",
                lat: 28.5507,
                lng: 54.3835,
                color: app.icons.green,
                title: 'نوجین'
            },
            {
                name: "marker14",
                lat: 28.7577,
                lng: 54.5074,
                color: app.icons.red,
                title: 'رونیز'
            },
            {
                name: "marker15",
                lat: 28.6722,
                lng: 54.9839,
                color: app.icons.green,
                title: 'نوایگان'
            },
            {
                name: "marker16",
                lat: 29.66,
                lng: 51.98,
                color: app.icons.red,
                title: 'دشت ارژن'
            },
            {
                name: "marker17",
                lat: 28.5363,
                lng: 53.57077,
                color: app.icons.green,
                title: 'درز و سایبان'
            },
            {
                name: "marker18",
                lat: 27.6588,
                lng: 52.6749,
                color: app.icons.red,
                title: 'گله دار'
            },
            {
                name: "marker19",
                lat: 29.2053,
                lng: 52.7525,
                color: app.icons.green,
                title: 'نوروزان'
            },
            {
                name: "marker20",
                lat: 30.3955,
                lng: 53.1331,
                color: app.icons.red,
                title: 'قره بلاغ'
            },
            {
                name: "marker21",
                lat: 29.4768,
                lng: 52.1927,
                color: app.icons.green,
                title: 'خسویه'
            },
            {
                name: "marker22",
                lat: 30.3054,
                lng: 52.2095,
                color: app.icons.red,
                title: 'کامفیروز'
            },
            {
                name: "marker23",
                lat: 29.8454,
                lng: 52.2063,
                color: app.icons.green,
                title: 'ماریان'
            },
            {
                name: "marker24",
                lat: 27.8866,
                lng: 53.4312,
                color: app.icons.green,
                title: 'خنج'
            },
            {
                name: "marker25",
                lat: 30.2446,
                lng: 53.2012,
                color: app.icons.red,
                title: 'قادرآباد'
            },
            {
                name: "marker26",
                lat: 30.5347,
                lng: 51.5848,
                color: app.icons.green,
                title: 'قنات نو'
            },
            {
                name: "marker27",
                lat: 28.8576,
                lng: 52.7537,
                color: app.icons.green,
                title: 'کردیان'
            },
            {
                name: "marker28",
                lat: 28.2530,
                lng: 53.9798,
                color: app.icons.red,
                title: 'سروستان'
            },
            {
                name: "marker29",
                lat: 28.9658,
                lng: 53.1197,
                color: app.icons.green,
                title: 'آسپاس'
            },
            {
                name: "marker30",
                lat: 28.4852,
                lng: 52.8153,
                color: app.icons.red,
                title: 'مزایجان'
            },
            {
                name: "marker31",
                lat: 29.1576,
                lng: 52.0235,
                color: app.icons.red,
                title: 'دهنو'
            },
            {
                name: "marker32",
                lat: 29.5328,
                lng: 53.2246,
                color: app.icons.green,
                title: 'حسن آباداقلید'
            },
            {
                name: "marker33",
                lat: 30.0727,
                lng: 52.3693,
                color: app.icons.red,
                title: 'پاسارگاد'
            },
            {
                name: "marker34",
                lat: 30.1461,
                lng: 52.5432,
                color: app.icons.red,
                title: 'شاپور'
            },
            {
                name: "marker35",
                lat: 28.0538,
                lng: 54.6522,
                color: app.icons.green,
                title: 'میمند'
            },
            {
                name: "marker36",
                lat: 29.7471,
                lng: 51.5517,
                color: app.icons.red,
                title: 'جشنیان'
            },
            {
                name: "marker37",
                lat: 27.5875,
                lng: 53.0476,
                color: app.icons.green,
                title: 'کلوان'
            },
            {
                name: "marker38",
                lat: 28.3466,
                lng: 52.9665,
                color: app.icons.red,
                title: 'افزر'
            },
            {
                name: "marker39",
                lat: 29.2013,
                lng: 54.3178,
                color: app.icons.red,
                title: 'نی ریز'
            },
            {
                name: "marker40",
                lat: 30.1648,
                lng: 53.1863,
                color: app.icons.green,
                title: 'دشمن زیاری'
            },
            {
                name: "marker41",
                lat: 31.722,
                lng: 52.459,
                color: app.icons.green,
                title: 'سرچهان'
            },
            {
                name: "marker42",
                lat: 27.7234,
                lng: 53.6142,
                color: app.icons.green,
                title: 'ارد'
            },


        ];

        for (var i = 0; i < markers.length; i++) {
            app.addMarker({
                name: markers[i].name,
                latlng: {
                    lat: markers[i].lat,
                    lng: markers[i].lng,
                },

                icon: markers[i].color,
                popup: {
                    title: {
                        i18n: markers[i].title,
                    },
                    class: 'marker-class',
                    open: true,
                },
                pan: false,
                draggable: true,
                history: false,
            });
        }
    });

</script>
