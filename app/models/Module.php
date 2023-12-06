<?php

class Module
{
    private string $code;
    private string $cliteral;
    private string $vliteral;
    private int $idCycle;

    public function __construct(string $code, string $cliteral, string $vliteral, int $idCycle)
    {
        $this->code = $code;
        $this->cliteral = $cliteral;
        $this->vliteral = $vliteral;
        $this->idCycle = $idCycle;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCliteral(): string
    {
        return $this->cliteral;
    }

    public function setCliteral(string $cliteral): void
    {
        $this->cliteral = $cliteral;
    }

    public function getVliteral(): string
    {
        return $this->vliteral;
    }

    public function setVliteral(string $vliteral): void
    {
        $this->vliteral = $vliteral;
    }

    public function getIdCycle(): int
    {
        return $this->idCycle;
    }

    public function setIdCycle(int $idCycle): void
    {
        $this->idCycle = $idCycle;
    }

    public function __toString(): string
    {
        return "Code -> " . $this->code . " CLiteral -> " . $this->cliteral . " VLiteral -> " . $this->vliteral . " IdCycle -> " . $this->idCycle;
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
            $array[] = new Module($line[0], $line[1], $line[2], $line[3]);
        }

        return $array;
    }
}
