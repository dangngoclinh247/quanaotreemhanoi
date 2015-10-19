<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/16/2015
 * Time: 11:41 AM
 */

namespace library;


class Cart
{
    private $_products;

    public function __construct()
    {
        $this->_products = array();
    }

    /**
     * @param $pro_id
     * @param $info
     * @param int $quantity
     */
    public function add_product($pro_id, $info, $quantity = 1)
    {
        //kiem tra xem ma san pham co trong gio hang chua
        $not_exists = true;
        foreach($this->_products as &$product)
        {
            if($product['pro_id'] == $pro_id)
            {
                $product['quantity'] += $quantity;
                $not_exists = false;
                break;
            }
        }
        //Neu chua ton tai thi them vao
        if($not_exists) {
            $this->_products[] = array(
                "quantity" => $quantity,
                "pro_id" => $pro_id,
                "info" => $info
            );
        }
    }

    /**
     * @param $pro_id
     * @param $quantity
     * @return bool
     */
    public function update_quantity($pro_id, $quantity)
    {
        $result = false;
        foreach($this->_products as &$product)
        {
            if($product['pro_id'] == $pro_id)
            {
                $product['quantity'] = $quantity;
                $result = true;
                break;
            }
        }
        return $result;
    }

    /**
     * @param $pro_id
     * @return bool
     */
    public function remove_product($pro_id)
    {
        $result = false;
        $products = $this->_products;
        foreach($products as $key => &$product)
        {
            if($product['pro_id'] == $pro_id)
            {
                unset($products[$key]);
                $result = true;
                break;
            }
        }
        $this->_products = $products;
        return $result;
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getPrice($product)
    {
        $price = $product['info']['pro_price'];
        if($product['info']['pro_price_sale'] > 0)
        {
            $price = $product['info']['pro_price_sale'];
        }
        return $product['quantity'] * $product['info']['pro_size'] * $price;
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        $result = 0;
        foreach($this->_products as $product)
        {
            $price = $product['info']['pro_price'];
            if($product['info']['pro_price_sale'] > 0)
            {
                $price = $product['info']['pro_price_sale'];
            }
            $result += $product['quantity'] * $product['info']['pro_size'] * $price;
        }
        return $result;
    }

    public function getProducts()
    {
        return $this->_products;
    }

    public function totalProduct()
    {
        return count($this->_products);
    }
}