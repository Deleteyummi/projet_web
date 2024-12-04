<?php
include_once(__DIR__ . '/../config.php');

class ProductsController{
    public function addProduct($product){
        $sql = "INSERT INTO products (name,price,image,description,categorie)
                VALUES(:name,:price,:image,:description,:categorie)";
        $db = config::getConnexion();
        try{
            $req = $db->prepare($sql);
            $req->execute([
                ':name'=>$product->getName(),
                ':price'=>$product->getPrice(),
                ':image'=>$product->getImage(),
                ':description'=>$product->getDescription(),
                ':categorie'=>$product->getCategorie()
            ]);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function showProducts(){
        $sql = "SELECT * FROM products";
        $db = config::getConnexion();
        try{
            $req = $db->query($sql);
            return $req->fetchAll();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function getProduct($id){
        $sql = "SELECT * FROM products WHERE id = :id";
        $db = config::getConnexion();
        try{
            $req = $db->prepare($sql);
            $req->bindValue(':id',$id);
            $req->execute();
            return $req->fetch();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function deleteProduct($id){
        $sql = "DELETE FROM products WHERE id = :id";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':id',$id);
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }

    public function updateProduct($product){
        $sql = "UPDATE products
                SET name=:name,price=:price,description=:description,categorie=:categorie, image=:image
                WHERE id=:id";
        try{
            $db = config::getConnexion();
            $req = $db->prepare($sql);
            $req->bindValue(':name',$product->getName());
            $req->bindValue(':price',$product->getPrice());
            $req->bindValue(':description',$product->getDescription());
            $req->bindValue(':categorie',$product->getCategorie());
            $req->bindValue(':image',$product->getImage());
            $req->bindValue(':id',$product->getId());
            $req->execute();
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}