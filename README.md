PHP HTML

Skrypt na prima aprilis :)

Przykładowe użycie:

//index.php
<?php

require 'phphtml.php';

$head->charset('utf-8');
$body->add('h1')->text('Hello World!);
$body->add('p')->text('Przykładowa aplikacja Hello World');
