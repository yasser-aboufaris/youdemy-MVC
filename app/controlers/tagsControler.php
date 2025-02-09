<?php
namespace App\Controller\TagsController;

use App\Controller\tags;
use App\Model\TagsDAO;



class TagsController
{
    public static function read(){
        Tags::read();
        include_once __DIR__ . '/../views/tags/index.php';
    }

    public function readByCourse($id){
        $tags = Tags::readByCourse($id);
        include_once __DIR__ . '/../views/tags/index.php';
    }
    
    public function delete($id){
        $tags = new Tags();
        $tags->setId($id);
        $tags->delete();
    }

    public function readAll()
    {
        TagsDaw::readAll();
    }
}