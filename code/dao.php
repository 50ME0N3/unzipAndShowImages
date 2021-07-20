<?php
require_once 'dbUtil.php';
session_start();
/**
 * créé un nouvelle utilisateur dans la base de donnée
 * @param $username string le nom de l'utilisateur
 * @param $pwd string son mot de passe haché en md5
 */
function createNewUser(string $username, string $pwd)
{
    $conn = myPdo();
    $query = $conn->prepare('SELECT `username`, Roles_idRoles from users where `Username`=:username limit 1');
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    var_dump($result);
    if($result == null){
        $query = $conn->prepare('INSERT INTO users SELECT null, :username, :pwd, idRoles FROM roles WHERE NomRole = "visiteur"');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':pwd', $pwd, PDO::PARAM_STR);
        $query->execute();
        header("location: login.php");
    }
    else{
        echo "Le nom d'utilisateur est déja utilisé";
    }
}

/**
 * log la personne selon son nom d'utilisateur et son mot de passe
 * @param $username string nom d'utilisateur de la personne qui veut se connecter
 * @param $Password string son mot de passe
 */
function login(string $username, string $Password)
{
    global $admin;
    $admin = false;
    $result = "";
	$conn = myPdo();
	try {
	    global $query;
		$query = $conn->prepare('SELECT `username`, Roles_idRoles from users where `Username`=:username and `Password`=:pwd limit 1');
		$query->bindParam(':username', $username, PDO::PARAM_STR);
		$query->bindParam(':pwd', $Password, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
		echo "ERREUR !";
		var_dump($query);
		var_dump($e->getMessage());
	}
	if($result != false) {
        if ($result["Roles_idRoles"] == 1) {
            global $admin;
            $admin = true;
        } else {
            global $admin;
            $admin = false;
        }
        if (count($result) > 0) {
            global $admin;
            $_SESSION["username"] = $username;
            $_SESSION["pwd"] = $Password;
            $_SESSION["admin"] = $admin;
            header("location: index.php", true);
        } else
            $erreur = "Mauvais login ou mot de passe!";
    }
	else{
	    echo "erreur";
    }
}

/**
 * affiche tout les utilisateur présent dans la base
 */
function echoAllUsers()
{
	$query = "SELECT *, NomRole FROM users as u JOIN roles as r on u.Roles_idRoles = r.idRoles";
	$result = myPdo()->query($query)->fetchAll();
	echo '<center>
			<table id="users">
			<tr>
			<td>Username</td>
			<td>Role</td>';
	if (count($_SESSION) != 0) {
		if ($_SESSION["admin"]) {
			echo "<td>modification</a></td>";
			echo "<td>suppression</a></td>";
		}
	}
	echo '</tr>';
	foreach ($result as $value) {
		echo "<tr>
			<td>" . $value[1] . "</td>
			<td>" . $value[5] . "</td>
			";
		if (count($_SESSION) != 0) {
			if ($_SESSION["admin"]) {
				echo "<td><a class=\"btn2\" href=\"update.php?name=" . $value[1] . "\">modifier</a></td>";
				echo "<td><a class=\"btn2\" href=\"delete.php?name=" . $value[1] . "\">supprimer</a></td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>
	</center>";
}

/**
 * retourne les infos d'un utilisateur présent dans la base
 * @param $username string le nom d'utilisateur dont on veut les infos
 * @return array retourne les infos de l'utilisateur
 */
function getInfo(string $username)
{
	$conn = myPdo();
	$sel = $conn->prepare("SELECT idUsers, username, NomRole from users INNER JOIN roles on users.Roles_idRoles = roles.idRoles where username=:username limit 1");
	$sel->bindParam(':username',$username,PDO::PARAM_STR);
	$sel->execute();
	return $sel->fetchAll();
}

/**
 * modifie un utilisateur dans la base
 * @param $username string le nouveau nom d'utilisateur
 * @param $pwd string le nouveau mot de passe
 * @param $id int l'id de l'utilisateur
 */
function update(string $username, string $pwd,int $id)
{
	$conn = myPdo();
	$query = $conn->prepare('UPDATE users SET `Username`=:username, `Password`=:pwd WHERE `idUsers` = :id');
	$query->bindParam(':username', $username, PDO::PARAM_STR);
	$query->bindParam(':pwd', $pwd, PDO::PARAM_STR);
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	$query->execute();
	echo $username . "<br>" . $pwd . "<br>" . $id;
	header("location: index.php");
}

/**
 * supprime un utilisateur de la base
 * @param $username string le nouveau nom d'utilisateur
 */
function delete(string $username)
{
	$conn = myPdo();
	$query = $conn->prepare('DELETE FROM users WHERE `username`=:username');
	$query->bindParam(':username', $username, PDO::PARAM_STR);
	$query->execute();
	header("location: index.php");
}
