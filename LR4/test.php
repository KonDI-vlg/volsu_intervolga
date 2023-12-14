<?php
// html строка
$html = "<div><p>Some text</p><img src=\"image1.jpg\" alt=\"Image 1\"><p>More text</p><img src=\"image2.png\" alt=\"Image 2\"></div>";

// создание объекта DOMDocument
$doc = new DOMDocument();

// загрузка html строки в объект
$doc->loadHTML($html);

// поиск всех тегов <img> в объекте
$images = $doc->getElementsByTagName("img");

// вывод всех атрибутов src
foreach ($images as $image) {
    echo $image->getAttribute("src");
}
?>