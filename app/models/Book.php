<?php

namespace app\models;

class Book
{
    private int $id;
    private int $idUser;
    private int $idModule;
    private string $publisher;
    private float $price;
    private int $pages;
    private string $status;
    private string $photo;
    private string $comments;
    private string $soldDate;

    public function __construct(int    $id, int $idUser, int $idModule, string $publisher,
                                float  $price, int $pages, string $status, string $photo,
                                string $comments, string $soldDate)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->idModule = $idModule;
        $this->publisher = $publisher;
        $this->price = $price;
        $this->pages = $pages;
        $this->status = $status;
        $this->photo = $photo;
        $this->comments = $comments;
        $this->soldDate = $soldDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getIdModule(): int
    {
        return $this->idModule;
    }

    public function setIdModule(int $idModule): void
    {
        $this->idModule = $idModule;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function setPages(int $pages): void
    {
        $this->pages = $pages;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getComments(): string
    {
        return $this->comments;
    }

    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    public function setSoldDate(string $soldDate)
    {
        $this->soldDate = $soldDate;
    }

    public function sold()
    {
        $this->setSoldDate("Sold");
    }

    public function __toString(): string
    {
        return "User -> " . $this->idUser . " idModule -> " . $this->idModule . " Publisher -> " . $this->publisher . " Precio -> " . $this->price . " Páginas -> " . $this->pages . " Estado -> " . $this->status . " Fecha de venta -> " . $this->soldDate;
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
}