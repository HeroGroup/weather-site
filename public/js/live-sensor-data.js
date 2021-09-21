var name = Date.now(),
    topic = "",
    uploadRoute = "/api/storeDeviceSensorData",
    fetchRoute = "/api/getLatestDeviceSensorData/";

window.onload = function() {

    client = new Paho.MQTT.Client("mqtt.flespi.io", Number(80), name);

    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client.connect({
        timeout: 1200,
        userName:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
        password:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
        useSSL: false,
        keepAliveInterval: 86400, // for one day
        onSuccess:onConnect
    });

    fetchLatestData();
};

function setTopic(input) {
    topic = input;
}

function onConnect() {
    // console.log("onConnect");
    setTimeout(function() { // wait for topic to be set
        client.subscribe(topic);
    }, 1000);
}

function onConnectionLost(responseObject) {
    if (responseObject.errorCode !== 0) {
        // console.log("onConnectionLost: " + responseObject.errorMessage);
    }

    client.connect({
        timeout: 1200,
        userName:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
        password:"7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
        useSSL: false,
        onSuccess:onConnect
    });
}

function parseData(body) {
    var temp = document.getElementById("temp"),
        humidity = document.getElementById("humidity"),
        radiation = document.getElementById("radiation"),
        rain = document.getElementById("rain"),
        wSpeed = document.getElementById("w_speed"),
        wDirection = document.getElementById("w_direction");

    if(parseFloat(temp.textContent).toFixed(1) !== parseFloat(body.temp).toFixed(1) && parseFloat(body.temp) !== -46.42) {
        temp.innerText = parseFloat(body.temp).toFixed(1);
        showChanges("temp");
    }

    if(parseFloat(humidity.textContent).toFixed() !== parseFloat(body.humidity).toFixed() && parseFloat(body.humidity) !== 3.00) {
        humidity.innerText = parseFloat(body.humidity).toFixed();
        showChanges("humidity");
    }

    if(parseFloat(radiation.textContent) !== parseFloat(body.soil)) {
        radiation.innerText = body.soil;
        showChanges("radiation");
    }

    if(parseFloat(rain.textContent) !== parseFloat(body.rain) && parseFloat(body.rain) !== 0.20) {
        rain.innerText = body.rain;
        showChanges("rain");
    }

    if(parseFloat(wSpeed.textContent).toFixed(1) !== parseFloat(body.w_speed).toFixed(1)) {
        wSpeed.innerText = parseFloat(body.w_speed).toFixed(1);
        showChanges("w_speed");
    }

    if(parseInt(wDirection.textContent) !== parseInt(body.w_direction)) {
        wDirection.innerText = parseInt(body.w_direction);
        showChanges("w_direction");
    }
}

function onMessageArrived(message) {
    // uploadData(message.payloadString);
    updateLastUpdate();
    parseData(JSON.parse(message.payloadString));
}

function showChanges(elm) {
    document.getElementsByClassName(elm)[0].classList.add("feature_box_active");
    document.getElementById(elm).style.color = "#fc301e";
    setTimeout(function() {
        document.getElementsByClassName(elm)[0].classList.remove("feature_box_active");
        document.getElementById(elm).style.color = "#222";
    }, 2000);
}

function updateLastUpdate() {
    var today = new Date(),
        hours = today.getHours(),
        minutes = today.getMinutes(),
        seconds = today.getSeconds(),
        // year = today.getFullYear(),
        // month = today.getMonth()+1,
        // day = today.getDate(),
        // time = year + "-" + (month.toString().length<2 ? '0'+month : month) + "-" + (day.toString().length<2 ? '0'+day : day) + " " + (hours.toString().length<2 ? '0'+hours : hours) + ":" + (minutes.toString().length < 2 ? '0'+minutes : minutes) + ":" + (seconds.toString().length < 2 ? '0'+seconds : seconds);
        time = (hours.toString().length<2 ? '0'+hours : hours) + ":" + (minutes.toString().length < 2 ? '0'+minutes : minutes) + ":" + (seconds.toString().length < 2 ? '0'+seconds : seconds) + " " + today.toLocaleDateString('fa-IR');

    var lastUpdate = document.getElementById("last-update");
    lastUpdate.innerText = time;
    lastUpdate.style.color = "#fc301e";
    setTimeout(function() {
        lastUpdate.style.color = "#333";
    }, 2000);
}

function uploadData(body) {
    var xhr = new XMLHttpRequest();
    let formData = new FormData();
    formData.append('deviceId', topic);
    formData.append('body', body);
    formData.append('_token', "{{csrf_token()}}");
    xhr.open('POST', uploadRoute, true);
    xhr.send(formData);
}

function fetchLatestData() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', fetchRoute+topic);
    xhr.addEventListener("load", function() {
        var response = JSON.parse(xhr.response);
        if(response.status === 1) {
            parseData(JSON.parse(response.data.parameters));

            var d = new Date(response.data.time),
                hours = d.getHours(),
                minutes = d.getMinutes(),
                seconds = d.getSeconds(),
                time = (hours.toString().length<2 ? '0'+hours : hours) + ":" + (minutes.toString().length < 2 ? '0'+minutes : minutes) + ":" + (seconds.toString().length < 2 ? '0'+seconds : seconds) + " " + d.toLocaleDateString('fa-IR');

            document.getElementById("last-update").innerText = time;
        }
    });
    xhr.send();
}

