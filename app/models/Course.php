<?php

class Course
{
    private string $cycle;
    private string $name;
    private int $idFamily;
    private string $vliteral;
    private string $cliteral;

    public function __construct(string $cycle, string $name, int $idFamily, string $vliteral, string $cliteral)
    {
        $this->cycle = $cycle;
        $this->name = $name;
        $this->idFamily = $idFamily;
        $this->vliteral = $vliteral;
        $this->cliteral = $cliteral;
    }

    public function getCycle(): string
    {
        return $this->cycle;
    }

    public function setCycle(string $cycle): void
    {
        $this->cycle = $cycle;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIdFamily(): int
    {
        return $this->idFamily;
    }

    public function setIdFamily(int $idFamily): void
    {
        $this->idFamily = $idFamily;
    }

    public function getVliteral(): string
    {
        return $this->vliteral;
    }

    public function setVliteral(string $vliteral): void
    {
        $this->vliteral = $vliteral;
    }

    public function getCliteral(): string
    {
        return $this->cliteral;
    }

    public function setCliteral(string $cliteral): void
    {
        $this->cliteral = $cliteral;
    }

    public function __toString(): string
    {
        return "Ciclo -> " . $this->cycle . " Familia -> " . $this->idFamily . " VLiteral -> " . $this->vliteral . " CLiteral -> " . $this->cliteral;
    }

    public function toJSON(): string
    {
        $json = "";
        foreach ($this as $key => $value) {
            $val = '"' . $value . '"';
            if (is_numeric($value)) {
                $val = $value;
            }
            $json .= '"' . $key . '":' . $val . ',';
        }

        return "{" . substr($json, 0, strlen($json) - 1) . "}";
    }

    public static function csvToArray(string $path): array
    {
        $array = [];
        $fp = fopen($path, 'r');

        while (!feof($fp) && ($line = fgetcsv($fp)) !== false) {
            $array[] = new Course($line[0], $line[1], $line[2], $line[3], $line[4]);
        }

        return $array;
    }
}