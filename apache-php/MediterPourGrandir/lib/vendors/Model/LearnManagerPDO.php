<?php
namespace Model;

use \OCFram\Manager;
use \OCFram\Lesson;
use \OCFram\Student;

class LearnManagerPDO extends Manager
{
	/*public function intervalLesson($student)
	{
		$bool = false;

		$q = $this->dao->prepare('SELECT id FROM `students` WHERE (dateLastLesson < DATE_SUB(NOW(), INTERVAL 96 HOUR)) AND id = :id');
	    $q->bindValue(':id', $student->id(), \PDO::PARAM_INT);
	    $q->execute();

	    if($q->fetch(\PDO::FETCH_ASSOC))
	    {
	    	$bool = true;
	    }

	    return $bool;

	}*/

	public function getIntervalLesson($student)
	{
		$q = $this->dao->prepare('SELECT TIME_FORMAT(TIMEDIFF((DATE_ADD(dateLastLesson, INTERVAL 96 HOUR)), NOW()), "%H heure(s) et %i minute(s) ") FROM students WHERE id = :id');
	    $q->bindValue(':id', $student->id(), \PDO::PARAM_INT);
	    $q->execute();

	    $getInterLesson = $q->fetch(\PDO::FETCH_NUM);

	    if($getInterLesson[0] > 0)
	    {
	    	return $getInterLesson[0];
	    }

	    return false;
	}


	public function getLesson($lesson)
	  {
	    $q = $this->dao->prepare('SELECT id, chapter_number, chapter, title, lesson, videoLink FROM lecon WHERE id = :lesson_number');
	    //$q->bindValue(':chapter_number', (int) $chapter, \PDO::PARAM_INT);
	    $q->bindValue(':lesson_number', (int) $lesson, \PDO::PARAM_INT);
	    $q->execute();
	    
	    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Lesson');
	    
	    return $q->fetch();
	  }

	 
	public function updateStudent($student)
	{
		$q = $this->dao->prepare('UPDATE students SET lesson = :updateLesson, level = :updateLevel, dateLastLesson = NOW() WHERE id = :id');
    
	    $q->bindValue(':updateLesson', $student->lesson(), \PDO::PARAM_INT);
	    $q->bindValue(':updateLevel', $student->level(), \PDO::PARAM_INT);
	    $q->bindValue(':id', $student->id(), \PDO::PARAM_INT);
	    
	    $q->execute();
	}



}