<?php
namespace app\controllers;

class Controller
{
    public function view($route, array $data = [])
    {
        // Destructurar el array
        extract($data);

        $route = str_replace('.', '/', $route);

        // ../resources/views/{$route}.php porque la ruta en realidad
        // se carga en el index.php
        if (file_exists("../resources/views/{$route}.php")) {

            // devuelve la vista pero no la muestra
            ob_start();
            include "../resources/views/{$route}.php";
            $content = ob_get_clean();
            return $content;
        } else {
            return "El archivo no exsite";
        }
    }

    public function redirect(string $route)
    {
        echo "todo ok";
        die();
        header("Location:{$route}");
    }
}