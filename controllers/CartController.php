<?php
include_once(__DIR__ . '/../config.php');

class CartController {

    public function addCart($cart){
        $sql = "INSERT INTO cart (id_user, total, status) VALUES(:id_user, :total, :status)";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_user', $cart->getIdUser());
            $req->bindValue(':total', $cart->getTotal());
            $req->bindValue(':status', $cart->getStatus());
            $req->execute();
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function deleteCart($id_cart){
        $sql = "DELETE FROM cart WHERE id_cart = :id_cart";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_cart', $id_cart);
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function updateTotal($total, $id_cart){
        $sql = "UPDATE cart SET total = :total WHERE id_cart = :id_cart";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':total', $total);
            $req->bindValue(':id_cart', $id_cart);
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function showAllCartsByUser($id_user){
        $sql = "SELECT * FROM cart WHERE id_user = :id_user AND status = :status";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_user', $id_user);
            $req->bindValue(':status', "Confirmé");
            $req->execute();
            return $req->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function showAllCarts(){
        $sql = "SELECT * FROM cart";
        try{
            $db = config::getConnexion();
            $req = $db->query($sql);
            return $req->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getCart($id_cart){
        $sql = "SELECT * FROM cart WHERE id_cart = :id_cart";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_cart', $id_cart);
            $req->execute();
            return $req->fetch();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function countOrderActive($id_user){
        $sql = "SELECT COUNT(cp.id_cart) AS nbr FROM cart c
                JOIN cartproducts cp ON c.id_cart = cp.id_cart
                WHERE c.status = :status AND c.id_user = :id_user";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':status', "Non confirmé");
            $req->bindValue(':id_user', $id_user);
            $req->execute();
            return (int) $req->fetchColumn();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function updateStatus($id_cart, $status){
        $sql = "UPDATE cart SET status = :status WHERE id_cart = :id_cart";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':status', $status);
            $req->bindValue(':id_cart', $id_cart);
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getNotConfirmedCart($id_user){
        $sql = "SELECT id_cart FROM cart WHERE id_user = :id_user AND status = :status";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_user', $id_user);
            $req->bindValue(':status', "Non confirmé");
            $req->execute();
            return $req->fetchColumn() ?: null;
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function joinCartCartProductsByUser($user){
        $sql = "SELECT * FROM cart c JOIN cartproducts cp ON c.id_cart = cp.id_cart
                WHERE c.status = :status AND c.id_user = :id_user";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':status', "Non confirmé");
            $req->bindValue(':id_user', $user);
            $req->execute();
            return $req->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getConfirmedCart() {
        $sql = "SELECT * FROM cart c JOIN cartproducts cp ON c.id_cart = cp.id_cart
                JOIN users u ON c.id_user = u.id
                WHERE c.status = :status";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':status', "Confirmé");
            $req->execute();
            return $req->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getOrderDetails($id_cart) {
        $sql = "SELECT * FROM cart c JOIN cartproducts cp ON c.id_cart = cp.id_cart
                JOIN products p ON cp.id_product = p.id
                JOIN users u ON c.id_user = u.id WHERE c.id_cart = :id_cart";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id_cart', $id_cart);
            $req->execute();
            return $req->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}