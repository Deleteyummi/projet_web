<?php
include_once(__DIR__ . '/../config.php');

class CartProductsController
{
    public function addCartProduct($cart_product){
        $sql = "INSERT INTO cartproducts (id_cart, id_product, quantite) 
                VALUES(:id_cart, :id_product, :quantite)";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_cart', $cart_product->getIdCart());
            $req->bindValue(':id_product', $cart_product->getIdProduct());
            $req->bindValue(':quantite', $cart_product->getQuantity());
            $req->execute();
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function deleteCartProduct($id_cart, $id_product){
        $sql = "DELETE FROM cartproducts WHERE id_cart = :id_cart AND id_product = :id_product";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_cart', $id_cart);
            $req->bindValue(':id_product', $id_product);
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function updateQuantite($quantite, $id_cart, $id_product){
        $sql = "UPDATE cartproducts SET quantite = :quantite 
                WHERE id_cart = :id_cart AND id_product = :id_product";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':quantite', $quantite);
            $req->bindValue(':id_cart', $id_cart);
            $req->bindValue(':id_product', $id_product);
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getOneCartProduct($id_cart, $id_product){
        $sql = "SELECT * FROM cartproducts WHERE id_cart = :id_cart AND id_product = :id_product";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_cart', $id_cart);
            $req->bindValue(':id_product', $id_product);
            $req->execute();
            return $req->fetch();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}