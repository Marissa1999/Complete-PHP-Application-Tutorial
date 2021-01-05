<?php

class Product extends Model
{
    var $name;
    var $description;
    var $price;

    public function get()
    {
        $SQL = 'SELECT * FROM Product';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $stmt->fetchAll();
    }

    public function create()
    {
        $SQL = 'INSERT INTO Product(name, description, price) VALUES(:name, :description, :price)';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['name'=>$this->name, 'description'=>$this->description, 'price'=>$this->price]);
        return $stmt->rowCount();
    }

    public function find($product_id)
    {
        $SQL = 'SELECT * FROM Product WHERE product_id = :product_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['product_id'=>$product_id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $stmt->fetch();
    }

    public function update()
    {
        $SQL = 'UPDATE Product SET name = :name, description = :description, price = :price WHERE product_id = :product_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['name'=>$this->name, 'description'=>$this->description_id, 'price'=>$this->price, 'product_id'=>$this->product_id]);
        return $stmt->rowCount();
    }

    public function delete()
    {
        $SQL = 'DELETE FROM Product WHERE product_id = :product_id';
        $stmt = self::$_connection->prepare($SQL);
        $stmt->execute(['product_id'=>$this->product_id]);
        return $stmt->rowCount();
    }


}

?>