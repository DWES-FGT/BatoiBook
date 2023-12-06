<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="./css/index.css"/>
</head>
<body>
<?php
const PATH_PROJECT = "/DWES/BatoiBook";
define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT']);
const COURSES_CSV_PATH = DOCUMENT_ROOT . PATH_PROJECT . "/resources/csv/coursesbook.csv";
const MODULES_CSV_PATH = DOCUMENT_ROOT . PATH_PROJECT . "/resources/csv/modulesbook.csv";

require(DOCUMENT_ROOT . PATH_PROJECT . "/app/models/Book.php");
require(DOCUMENT_ROOT . PATH_PROJECT . "/app/models/Course.php");
require(DOCUMENT_ROOT . PATH_PROJECT . "/app/models/Module.php");
require(DOCUMENT_ROOT . PATH_PROJECT . "/app/models/User.php");

$courses = Course::csvToArray(COURSES_CSV_PATH);
$modules = Module::csvToArray(MODULES_CSV_PATH);

try {
    $fran = new User("fran", "FranGT12", "franchu");
} catch (Exception $e) {
    echo "<p>" . $e->getMessage() . "</p>";
}

$bookFran = new Book(1, $modules[3]->getCode(), "S.L", 19.95,
    200, "New", "", "Libro muy recomendado", "");
?>

<h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-6">Usuario <?= $fran->getNick() ?></h1>

<h2 class="text-lg font-bold tracking-tight text-gray-900">__toString</h2>
<p><?= $fran ?></p>

<h2 class="text-lg font-bold tracking-tight text-gray-900">toJSON</h2>
<p><?= $fran->toJSON() ?></p>

<h1 class="text-3xl font-bold tracking-tight text-gray-900 mt-12 mb-6">Libro</h1>

<h2 class="text-lg font-bold tracking-tight text-gray-900">__toString</h2>
<p><?= $bookFran ?></p>

<h2 class="text-lg font-bold tracking-tight text-gray-900">toJSON</h2>
<p><?= $bookFran->toJSON() ?></p>

<h1 class="text-3xl font-bold tracking-tight text-gray-900 mt-12 mb-8">Courses</h1>
<table class="w-full mx-0 mt-0">
    <thead>
    <tr class="text-md font-semibold tracking-wide text-center text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
        <th class="px-4 py-3">Cycle</th>
        <th class="px-4 py-3">Name</th>
        <th class="px-4 py-3">IdFamily</th>
        <th class="px-4 py-3">VLiteral</th>
        <th class="px-4 py-3">CLiteral</th>
    </tr>
    </thead>
    <tbody class="bg-white">
    <?php foreach ($courses as $course): ?>
        <tr class="text-gray-700">
            <td class="px-4 py-3 text-center text-xs border">
                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm"><?= $course->getCycle() ?> </span>
            </td>
            <td class="px-4 py-3 text-ms font-semibold border"><?= $course->getName() ?></td>
            <td class="border">
                <div class="flex items-center text-sm">
                    <div class="px-4 py-3">
                        <p class="font-semibold text-black"> <?= $course->getIdFamily() ?></p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-sm border"><?= $course->getVliteral() ?></td>
            <td class="px-4 py-3 text-sm border"><?= $course->getCliteral() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h1 class="text-3xl font-bold tracking-tight text-gray-900 mt-12 mb-8">Courses</h1>
<table class="w-full mx-0 mt-0">
    <thead>
    <tr class="text-md font-semibold tracking-wide text-center text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
        <th class="px-4 py-3">Code</th>
        <th class="px-4 py-3">CLiteral</th>
        <th class="px-4 py-3">VLiteral</th>
        <th class="px-4 py-3">IdCycle</th>
    </tr>
    </thead>
    <tbody class="bg-white">
    <?php foreach ($modules as $module): ?>
        <tr class="text-gray-700">
            <td class="px-4 py-3 text-center text-xs border">
                <span class="px-2 py-1 font-semibold leading-tight text-cyan-700 bg-cyan-200 rounded-sm"> <?= $module->getCode() ?>  </span>
            </td>
            <td class="px-4 py-3 text-ms font-semibold border"><?= $module->getCliteral() ?></td>
            <td class="px-4 py-3 text-sm border"><?= $module->getVliteral() ?></td>
            <td class="border">
                <div class="flex items-center text-sm">
                    <div class="px-4 py-3">
                        <p class="font-semibold text-black text-center"><?= $module->getIdCycle() ?></p>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>