<?php 

	// @author FN-FAL113

	/*$pdo = new PDO('mysql:host=localhost;port=3306;', 'root', ''); 
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set error

	$query = $pdo->prepare('CREATE DATABASE IF NOT EXISTS `blog_site` ');
	$query->execute(); 


	$query = $pdo->prepare('CREATE TABLE IF NOT EXISTS `users` ');
	$query->execute(); */

	$db = new PDO('mysql:host=localhost;port=3306;dbname=TYPE_DB_NAME_HERE', 'root', ''); 
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// insertUser($db, "Test", "Test", "male", "america", "testb@email.com", "none.jpeg", "062821723", "test");

	// deleteUserByName($db, "Test", "Test");

	//getUserByName($db, 'Test', 'Test');

	// updateName($db, 'Tes2t', 'Test2', 'Test', 'Test');

	function insertUser($db, $first_name, $last_name, $gender, $address, $email, $photo, $contact_number, $password){
		if(!isSameUser($db, $first_name, $last_name)){
			$query = $db->prepare('INSERT INTO `users` ( `first_name`, `last_name`, `gender`, `address`, `email`, `photo`, `contact_number`, `password`) VALUES ( :first_name, :last_name ,:gender , :address , :email , :photo , :contact_number , :password ) ');

			$query->bindValue(':first_name', $first_name);
			$query->bindValue(':last_name', $last_name);
			$query->bindValue(':gender', $gender);
			$query->bindValue(':address', $address);
			$query->bindValue(':email', $email);
			$query->bindValue(':photo', $photo);
			$query->bindValue(':contact_number', $contact_number);
			$query->bindValue(':password', md5($password));
			$query->execute();
		} else {
			echo "User already existed! please add a different user <br>";
		}

	}

	function updateName($db, $first_name, $last_name, $new_first_name, $new_last_name){
		$query = $db->prepare('UPDATE `users` SET `first_name` = :new_first_name, `last_name` = :new_last_name WHERE `users`. `first_name` = :first_name AND `users`.`last_name` = :last_name ');
		$query->bindValue(':first_name', $first_name);
		$query->bindValue(':last_name', $last_name);
		$query->bindValue(':new_first_name', $new_first_name);
		$query->bindValue(':new_last_name', $new_last_name);
		$query->execute();

	}

	function deleteUserByName($db, $first_name, $last_name){
		if(getUserByName($db, $first_name, $last_name)){
			$query = $db->prepare('DELETE FROM `users` where `users`.`first_name` = :first_name AND `users`.`last_name` = 	:last_name');
			$query->bindValue(':first_name', $first_name);
			$query->bindValue(':last_name', $last_name);
			$query->execute();
			$data = $query->fetch(PDO::FETCH_ASSOC);

			echo 'user is successfully deleted from the database';
		} else {
			echo 'wrong info or user does not exist!';
		}
		
	}

	function getUserByName($db, $first_name, $last_name){
		$query = $db->prepare('SELECT * FROM `users` where `users`.`first_name` = :first_name AND `users`.`last_name` = :last_name');
		$query->bindValue(':first_name', $first_name);
		$query->bindValue(':last_name', $last_name);

		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);

		if($data['first_name'] == $first_name && $data['last_name'] == $last_name){
			return true;
		} else {
			echo 'user does not exist!';
			return false;
		}
		
	}

	function isSameUser($db, $first_name, $last_name){
		$query = $db->prepare('SELECT * FROM `users` where `users`.`first_name` = :first_name AND `users`.`last_name` = :last_name');
		$query->bindValue(':first_name', $first_name);
		$query->bindValue(':last_name', $last_name);

		$query->execute();
		$data = $query->fetch(PDO::FETCH_ASSOC);

		if($data['first_name'] == $first_name && $data['last_name'] == $last_name){
			return true;
		}
		return false;
	}


?>
