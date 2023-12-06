<?php

namespace app\models;

use Exception;

class User extends QueryBuilder
{
    protected $table = "users";
    const PASSWORD_REGEX = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/";

    private int $id;
    private string $email;
    private string $nick;
    private string $password;


    public function __construct(int $id, string $email, string $nick, string $password)
    {
        if (!$this->isValidPassword($password)) {
            throw new Exception("Password no válida");
        }
        $this->id = $id;
        $this->email = $email;
        $this->nick = $nick;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function __toString(): string
    {
        return "Id -> " . $this->id . " Nick -> " . $this->nick . " Email -> " . $this->email . " Password -> " . $this->password;
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