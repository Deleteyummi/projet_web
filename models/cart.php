<?php

class Cart
{
    private int $id_cart;
    private int $id_user;
    private float $total;
    private $date_cart;
    private string $status;

    public function __construct(int $id_cart, int $id_user, float $total,$date_cart, string $status){
        $this->id_cart = $id_cart;
        $this->id_user = $id_user;
        $this->total = $total;
        $this->date_cart = $date_cart;
        $this->status = $status;
    }

    public function getIdCart(): int
    {
        return $this->id_cart;
    }

    public function setIdCart(int $id_cart): void
    {
        $this->id_cart = $id_cart;
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): void
    {
        $this->id_user = $id_user;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getDateCart()
    {
        return $this->date_cart;
    }
    public function setDateCart($date_cart): void
    {
        $this->date_cart = $date_cart;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

}