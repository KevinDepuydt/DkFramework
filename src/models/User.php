<?php 
 
namespace Core\Models; 
 
use ORM\Entity\Entity; 
 
class User extends Entity 
{ 
	const TABLE = 'users'; 
	protected $id; 
	protected $mail; 
	protected $sexe; 
	protected $nickname; 

 
	public function __construct() { 
	} 
 

 
	public function setId($id) { 
		$this->id = $id;
	} 
 
	public function getId() { 
		return $this->id;
	} 
 
	public function setMail($mail) { 
		$this->mail = $mail;
	} 
 
	public function getMail() { 
		return $this->mail;
	} 
 
	public function setSexe($sexe) { 
		$this->sexe = $sexe;
	} 
 
	public function getSexe() { 
		return $this->sexe;
	} 
 
	public function setNickname($nickname) { 
		$this->nickname = $nickname;
	} 
 
	public function getNickname() { 
		return $this->nickname;
	} 
 
}