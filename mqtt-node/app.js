var http = require('http');
var mqtt = require('mqtt');
const axios = require('axios').default;

let token = "7nlbcTUtpbZP7bnEHvuwfiVBQ8AJ4xK1KU2MBM5QLSuJTHdq0vK6DwxjuVQogpdP",
    uploadRoute = "http://ws2.itmc.ir/api/storeDeviceSensorData",
    cyan = "\x1b[36m%s\x1b[0m", red = "\x1b[31m%s\x1b[0m";

const uploadData = async (topic, data) => {
    let body = {"deviceId": topic, "body": data};
    axios.post(uploadRoute, body)
        .then(function (response) {
            // console.log(response.data);
        })
        .catch(function (error) {
            console.log("error: " + error.toString());
        });
};

console.log("initiating connetion...");

client = mqtt.connect('ws://mqtt.flespi.io', { username:token , password:token });

client.on('connect', function () {

    client.subscribe("1234567890", function(err) {
        if(err) {
            console.log(red, err.toString());
        } else {
            console.log(cyan, "subscribed to 1234567890");
        }
    });

    client.subscribe("987654321", function(err) {
        if(err) {
            console.log(red, err.toString());
        } else {
            console.log(cyan, "subscribed to 987654321");
        }
    });

});

client.on('message', function (topic, message) {
    try {
        var today = new Date(),
            hours = today.getHours(),
            minutes = today.getMinutes(),
            seconds = today.getSeconds(),
            time = (hours.toString().length<2 ? '0'+hours : hours) + ":" + (minutes.toString().length < 2 ? '0'+minutes : minutes) + ":" + (seconds.toString().length < 2 ? '0'+seconds : seconds);

        // console.log(time + ": " + message.toString());

        var incomingJson = JSON.parse(message.toString());
        uploadData(topic,incomingJson);

    } catch (e) {
        console.log(e.toString());
    }
});
