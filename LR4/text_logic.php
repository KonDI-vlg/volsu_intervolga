<?php


global $freqs;

function count_words($html) {
    global $freqs;
    $text = strip_tags(html_entity_decode($html));
    $text = mb_strtolower($text, 'UTF-8');
    $words = preg_split("/[\s\p{P}\p{Z}\p{N}]+/u", $text, -1, PREG_SPLIT_NO_EMPTY);
    $freqs = array();
    $stopwords = array('а', 'без', 'более', 'бы', 'был', 'была', 'были', 'было', 'быть', 'в', 'вам', 'вас', 'весь', 'во', 'вот', 'все', 'всего', 'всех', 'вы', 'где', 'да', 'даже', 'для', 'до', 'его', 'ее', 'если', 'есть', 'еще', 'же', 'за', 'здесь', 'и', 'из', 'или', 'им', 'их', 'к', 'как', 'ко', 'когда', 'кто', 'ли', 'либо', 'мне', 'может', 'мы', 'на', 'надо', 'наш', 'не', 'него', 'нее', 'нет', 'ни', 'них', 'но', 'ну', 'о', 'об', 'однако', 'он', 'она', 'они', 'оно', 'от', 'очень', 'по', 'под', 'при', 'с', 'со', 'так', 'также', 'такой', 'там', 'те', 'тем', 'то', 'того', 'тоже', 'той', 'только', 'том', 'ты', 'у', 'уже', 'хотя', 'чего', 'чей', 'чем', 'что', 'чтобы', 'чье', 'чья', 'эта', 'эти', 'это', 'я');
    foreach ($words as $word) {
        if ($word != '' && !in_array($word, $stopwords)) {
            if (isset($freqs[$word])) {
                $freqs[$word]++;
            } else {
                $freqs[$word] = 1;
            }
        }
    }
    arsort($freqs);
    $freqs = array_slice($freqs, 0, 100);
    foreach ($freqs as $word => $freq) {
        echo "<a href=\"#{$word}\">{$word} ({$freq})</a><br>";
    }
}

function print_html($html,$freqs) {
    $html = html_entity_decode($html);
    $html = mb_strtolower($html, 'UTF-8');
    foreach ($freqs as $word => $freq) {
        $html = preg_replace("/(?<=\s|^)$word(?=\s|\p{P})/u", "<span id=\"$word\">$word</span>", $html, 1);
    }
    echo $html;
}

function print_words($freqs) {
    arsort($freqs);
    $freqs = array_slice($freqs, 0, 100);
    foreach ($freqs as $word => $freq) {
        echo "<a href=\"#{$word}\">{$word} ({$freq})</a><br>";
    }
}

function clean_html($html) {
    $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'table', 'tr', 'td', 'th', 'a');
    $html = strip_tags(html_entity_decode($html), '<' . implode('><', $allowed_tags) . '>');
    $html = preg_replace('/<([a-z]+) [^>]+>/i', '<$1>', $html);
    return $html;
}

function print_images($html){
    $doc = new DOMDocument();
    $source = [];
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);
    libxml_use_internal_errors(false);
    $images = $doc->getElementsByTagName('img');
    foreach ($images as $image) {
        $source[] = $image->getAttribute('src');
    }
    return $source;
}

function punctuation($html){
    // Расставляем запятые перед "а" и "но"
    $html = preg_replace('/(\s|^)([А-Яа-яЁё]+)(\s)([аА])/', '$1$2,$3$4', $html);
    $html = preg_replace('/(\s|^)([А-Яа-яЁё]+)(\s)([ноНО])/', '$1$2,$3$4', $html);

    // Заменяем три точки на многоточие
    $html = str_replace('...', '…', $html);

    echo $html;
}




