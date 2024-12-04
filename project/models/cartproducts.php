<?php

class cartproducts
{
    private int $id_cart;
    private int $id_product;
    private int $quantity;

    public function __construct(int $id_cart, int $id_product, int $quantity){
        $this->id_cart = $id_cart;
        $this->id_product = $id_product;
        $this->quantity = $quantity;
    }

    public function getIdCart(): int
    {
        return $this->id_cart;
    }

    public function setIdCart(int $id_cart): void
    {
        $this->id_cart = $id_cart;
    }

    public function getIdProduct(): int
    {
        return $this->id_product;
    }

    public function setIdProduct(int $id_product): void
    {
        $this->id_product = $id_product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}