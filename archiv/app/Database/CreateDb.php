<?php

try {
  $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);    
  // set the PDO error mode to exception    
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
  // sql to create table   
  $sql = "CREATE TABLE users ( user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(40) NOT NULL, password VARCHAR(40) NOT NULL, email VARCHAR(60), register_date TIMESTAMP )";


	$statements = [
	'CREATE TABLE state( 
		state_id	INT AUTO_INCREMENT,
		state_data	VARCHAR(100) NOT NULL,
		PRIMARY KEY(state_id)
	);',
	'CREATE TABLE github (
		github_id	INT AUTO_INCREMENT, 
		data		INT NOT NULL, 
		PRIMARY KEY(book_id, author_id), 
		CONSTRAINT fk_book 
			FOREIGN KEY(book_id) 
			REFERENCES books(book_id) 
			ON DELETE CASCADE, 
			CONSTRAINT fk_author 
				FOREIGN KEY(author_id) 
				REFERENCES authors(author_id) 
				ON DELETE CASCADE
	)'];




  // use exec() because no results are returned
  $conn->exec($sql);
  echo "users table created successfully";
} catch (PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;  