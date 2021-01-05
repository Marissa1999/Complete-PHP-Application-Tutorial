<?php

/**
 * @accessFilter:{LoginFilter}
 */

class ProductController extends Controller
{
    public function index()
    {
        $products = $this->model('Product')->get();
        $this->view('product/index', ['products'=>$products]);
    }


    public function addPicture($product_id)
    {
        if(isset($_FILES['newPicture']) && $_FILES['newPicture']['error'] == UPLOAD_ERR_OK)
        {
            $info = getimagesize($_FILES['newPicture']['tmp_name']);
            $allowedTypes = [IMAGETYPE_JPEG=>'.jpg', IMAGETYPE_PNG=>'.png', IMAGETYPE_GIF=>'.gif'];

            if($info === false)
            {
                $this->view('product/addPicture', ['error' => 'Bad File Format']);
            }
            else if(!array_key_exists($info[2], $allowedTypes))
            {
                $this->view('product/addPicture', ['error'=>'Not an Accepted File Type']);
            }
            else
            {
                $path = getcwd().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
                $filename = uniqid().$allowedTypes[$info[2]];
                move_uploaded_file($_FILES['newPicture']['tmp_name'], $path.$filename);

                $newPicture = $this->model('Picture');
                $newPicture->product_id = $product_id;
                $newPicture->filename = $filename;
                $newPicture->description = $_POST['description'];
                $newPicture->create();
                header('location:/product/index');
            }
        }
        else
        {
            $this->view('product/addPicture');
        }
    }

    public function deletePicture($picture_id)
    {
        $thePicture = $this->model('Picture')->find($picture_id);
        unlink(getcwd().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$thePicture->filename);
        $thePicture->delete();
        header('location:/product/index');
    }

    public function create()
    {
        if(isset($_POST['action']))
        {
            $newProduct = $this->model('Product');
            $newProduct->name = $_POST['name'];
            $newProduct->description = $_POST['description'];
            $newProduct->price = $_POST['price'];
            $newProduct->product_id= $_SESSION['product_id'];
            $newProduct->create();
            header('location:/product/index');
        }

        else
        {
            $this->view('product/create');
        }
    }

    public function detail($product_id)
    {
        $theProduct = $this->model('Product')->find($product_id);
        $thePictures = $this->model('Picture')->getForProduct($product_id);
        $theProduct->pictures = $thePictures;
        $this->view('product/detail', $theProduct);
    }

    public function edit($product_id)
    {
        $theProduct = $this->model('Product')->find($product_id);

        if(isset($_POST['action']))
        {
            $theProduct->name = $_POST['name'];
            $theProduct->description = $_POST['description'];
            $theProduct->price = $_POST['price'];
            $theProduct->update();
            header('location:/product/index');
        }

        else
        {
            $this->view('product/edit', $theProduct);
        }
    }


    public function delete($product_id)
    {
        $theProduct = $this->model('Product')->find($product_id);

        if(isset($_POST['action']))
        {
            $theProduct->delete();
            header('location:/product/index');
        }

        else
        {
            $this->view('product/delete', $theProduct);
        }
    }
}

?>