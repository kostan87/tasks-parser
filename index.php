<!DOCTYPE html>
<html>
<head>
  <title>SW RP</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<script>
function decode(str){
  return str.replace(/&quot;/g,'"')
  .replace(/&gt;/g,'>')
  .replace(/&lt;/g,'<')
  .replace(/&amp;/g,'&')
}

<?php
$html = file_get_contents("https://freelance.habr.com/tasks");
$html2 = "<html>";
echo "page = `" . htmlspecialchars($html) . "`;";
?>

let html = document.createElement("html");
html.innerHTML = decode(page);

let tasks = html.querySelectorAll(".content-list__item > article");

for (let task of tasks) {
  let url = "https://freelance.habr.com"
  let title = task.querySelector(".task__title").getAttribute("title");
  let link = url + task.querySelector(".task__title > a").getAttribute("href");
  let responses = task.querySelectorAll(".params__count")[0];
  if (!responses) { 
    responses = "0"
  } else {
    responses = responses.innerHTML
  }
  let views = task.querySelectorAll(".params__count")[1];
  if (!views) {
    views = "0"
  } else {
    views = views.innerHTML
  }
  let time = task.querySelector(".params__published-at.icon_task_publish_at > span").innerHTML;
  let price = task.querySelector(".task__price > span").innerText;

  div = document.createElement("div");
  div.innerHTML = `${title}   Отклики: ${responses} | Просмотры: ${views} | Время: ${time} | Цена: ${price}`;
  document.body.append(div);
}

function sendNotification(title, options) {
  if (Notification.permission === "granted") {
    var notification = new Notification(title, options);
    function clickFunc() { alert('Пользователь кликнул на уведомление'); }
    notification.onclick = clickFunc;
  } else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      if (permission === "granted") {
        var notification = new Notification(title, options);
      } else {
        alert('Вы запретили показывать уведомления'); // Юзер отклонил наш запрос на показ уведомлений
      }
    });
  } else {
    Notification.requestPermission(function (permission) {
      if (permission === "granted") {
        var notification = new Notification(title, options);
      } else {
        alert('Вы запретили показывать уведомления'); // Юзер отклонил наш запрос на показ уведомлений
      }
    });
  }
}
/*
POST /fcm/send HTTP/1.1
Host: fcm.googleapis.com
Authorization: key=AAAAaGQ_q2M:APA91bGCEOduj8HM6gP24w2LEnesqM2zkL_qx2PJUSBjjeGSdJhCrDoJf_WbT7wpQZrynHlESAoZ1VHX9Nro6W_tqpJ3Aw-A292SVe_4Ho7tJQCQxSezDCoJsnqXjoaouMYIwr34vZTs
Content-Type: application/json

{
  "data": {
    "title": "Bubble Nebula",
    "body": "It's found today at 21:00",
    "icon": "https://peter-gribanov.github.io/serviceworker/Bubble-Nebula.jpg",
    "image": "https://peter-gribanov.github.io/serviceworker/Bubble-Nebula_big.jpg",
    "click_action": "https://www.nasa.gov/feature/goddard/2016/hubble-sees-a-star-inflating-a-giant-bubble"
  }
  "to": "YOUR-TOKEN-ID"
}
*/
</script>
</body>
</html>
