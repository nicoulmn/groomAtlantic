<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\CommentsModel;


class CommentsController extends Controller
{

    // fonction récupérant la liste des commentaires attribués au concierge
    public function commentList(){

        $commentsModel = new CommentsModel();
        $comments= $commentsModel->showCommentById();

        return $comments;
    }

    // fonction récupérant la liste des commentaires laissés aux concierge
    public function commentListOwner(){

        $commentsModel = new CommentsModel();
        $ownerComments= $commentsModel->showCommentsById();

        return $ownerComments;
    }
    
    // fonction récupérant les auteurs des commentaires attribués au concierge
    public function commentsAuthor(){

        $commentsAuthor = new CommentsModel();
        $commentsAut = $commentsAuthor->commentsAuthorName();
        
        return $commentsAut;
    }

    // fonction récupérant les concierges ayant reçus un commentaires
    public function commentsAddressee(){

        $commentsModel = new CommentsModel();
        $commentsAddr = $commentsModel->commentsAddresseeName();
        
        return $commentsAddr;
    }

    
}
    
  