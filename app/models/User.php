<?php

namespace app\models;

class User
{
    const PASSWORD_REGEX = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/";

    private string $name;
    private string $password;
    private string $nick;

    public function __construct(string $name, string $password, string $nick)
    {
        if (!$this->isValidPassword($password)) {
            throw new Exception("Password no válida");
        }
        $this->name = $name;
        $this->password = $password;
        $this->nick = $nick;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function __toString(): string
    {
        return "Nombre -> " . $this->name . " Password -> " . $this->password .
            " Nick -> " . $this->nick;
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

    public function isValidPassword(string $password)
    {
        return preg_match(self::PASSWORD_REGEX, $password);
    }

}