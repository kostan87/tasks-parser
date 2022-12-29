<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
  if (0 === error_reporting()) {
      return false;
  }
  throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

function getTasks() {
  $page = file_get_contents("https://freelance.habr.com/tasks");
  $doc = new DOMDocument();
  $doc->loadHtml($page, LIBXML_NOERROR);
  $html = simplexml_import_dom($doc);
  $tasks = $html->xpath("//*[@id='tasks_list']")[0];
  $tasks->rewind();

  $date = date('H:i:s');
  $tasks_list = [
    "date" => $date,
    Array()
  ];

  for ($i = 1; $i <= count($tasks); $i++) {
    $task = $tasks->current();
    $title = $task->xpath("article/div/header/div[1]/a")[0]->__toString();
    try {
      $responses = $task->xpath("article/div/header/div[2]/span[1]/i")[0]->__toString();
      try {
        $views = $task->xpath("article/div/header/div[2]/span[2]/i")[0]->__toString();
      } catch (Exception $e) {
        $responses = "0";
        $views = $task->xpath("article/div/header/div[2]/span[1]/i")[0]->__toString();
      }
    } catch (Exception $e) {
      $responses = "0";
      $views = "0";
    }
    try {
      $time = $task->xpath("article/div/header/div[2]/span[3]/span")[0]->__toString();
    } catch (Exception $e) {
      $time = $task->xpath("article/div/header/div[2]/span[2]/span")[0]->__toString();
    }
    $link = "https://freelance.habr.com" . $task->xpath("article/div/header/div[1]/a")[0]->attributes();
    $price = $task->xpath("article/aside/div/span")[0]->__toString();

    array_push($tasks_list[0], [
      "title" => $title,
      "responses" => $responses,
      "views" => $views,
      "time" => $time,
      "price" => $price,
      "link" => $link
    ]);
    $tasks->next();
  }
  return $tasks_list;
}

$json = json_encode(getTasks());
$filename = __DIR__ . '/file.json';
$fh = fopen($filename, 'w');
fwrite($fh, $json);
fclose($fh);
?>
