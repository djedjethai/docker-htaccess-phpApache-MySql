<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Feedback;

class FeedbackManagerPDO extends Manager
{

  public function add(Feedback $feedback)
  {
      // A VOIR, SI POSSIBLE DE FAIRE LES 3 MANIP EN UNE SEULE REQ......??????????
     //we add the new news
      $requete = $this->dao->prepare('INSERT INTO feedback SET studentId = :studentId, contenu = :contenu, grade = :grade,  datePost = NOW()');
      $requete->bindValue(':studentId', $feedback->studentId());
      $requete->bindValue(':contenu', $feedback->contenu());
      $requete->bindValue(':grade', $feedback->grade());
      $requete->execute();
  }

  public function update(Feedback $feedback)
  {
      // A VOIR, SI POSSIBLE DE FAIRE LES 3 MANIP EN UNE SEULE REQ......??????????
     //we add the new news
      $requete = $this->dao->prepare('UPDATE feedback SET contenu = :contenu, grade = :grade,  datePost = NOW() WHERE studentId = :studentId');
      
      $requete->bindValue(':studentId', $feedback->studentId());
      $requete->bindValue(':contenu', $feedback->contenu());
      $requete->bindValue(':grade', $feedback->grade());
      $requete->execute();
  }

   //   protected function modify($feedback)
    // {
   //   $requete = $this->dao->prepare('UPDATE news SET titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
    
   //   $requete->bindValue(':titre', $news->titre());
    //  $requete->bindValue(':contenu', $news->contenu());
   //     $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
    
   //   $requete->execute();
    // }

  public function getFeedback($debut = -1, $limite = -1)
  {
      $sql = 'SELECT feedback.id, pseudo, grade, contenu, datePost FROM feedback INNER JOIN students ON feedback.studentId = students.id';

      if ($debut != -1 || $limite != -1)
      {
          $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
      }

      $requete = $this->dao->query($sql);
      $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Feedback');
    
      $listFeedback = $requete->fetchAll();


      foreach ($listFeedback as $feedback)
      {
          $feedback->setDatePost(new \DateTime($feedback->datePost()));
      }
    
      $requete->closeCursor();
    
      return $listFeedback;


      //$q->bindValue(':chapter_number', (int) $chapter, \PDO::PARAM_INT);
      // $q->execute();
      
      // $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Feedback');
      
      // return $q->fetch();
  }

  public function haveFeedBack($id) 
  {
    $exist = false;

    $q = $this->dao->prepare('SELECT COUNT(*) FROM feedback WHERE studentId = :id');
    
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    
    $q->execute();
    
    if (intval($q->fetchColumn()) > 0)
      {
        $exist = true;
      }

    return $exist;
  }

  public function getOldFeedback($id)
  {
    $q = $this->dao->prepare('SELECT id, contenu, grade FROM feedback WHERE studentId = :id');
    $q->bindValue(':id', $id);
    $q->execute();

    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Feedback');
    
    return $q->fetch();

  }

}