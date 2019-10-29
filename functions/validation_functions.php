<?php
    require_once("settings.php");
    global $conn;
    // check if input is not empty and contains not only empty spaces
    function empty_check($input) { 
        if (strlen(trim($input)) === 0) {   
            return true;
        } else{
            return false;
        }
    }

    // check if 
   

    // TODO: patterns need verfication!
    function pattern_check($input, $type) {
        $email_pattern = '/^[A-Za-z0-9._]+@^[a-z]+.^[a-z]+$/';
        $profile_pattern = '/^[A-Za-z ]+/';
        $password_pattern = '/^[A-Za-z0-9]+$/';
        $number_pattern = '/^[0-9]*$/';
        if ($type === "email") {
            return preg_match($email_pattern, $input);
        } else if ($type === "profile") {
            return preg_match($profile_pattern, $input);
        } else if ($type === "password") {
            return preg_match($password_pattern, $input);
        } else if ($type === "number") {
            return preg_match($number_pattern, $input);
        }
    }
    // check if email already registered
    function friend_email_exist($input) {
        global $conn;
        $sql = "SELECT friend_email FROM friends WHERE friend_email = '" . $input . "'; ";
        
        if ($result = $conn->query($sql)) {
            //echo "<p>Query executed!</p>";
            if ($result->num_rows > 0) {
                return true;
            } else {
            return false;
            } 
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // check if two ids are already friends
    function relationship_exist($id1, $id2) {
        global $conn;
        $sql = "SELECT * FROM myfriends 
                WHERE (friend_id1 = '" . $id1 . "' AND friend_id2 = '" . $id2 . "')
                    OR (friend_id1 = '" . $id2 . "' AND friend_id2 = '" . $id1 . "')";
        if ($result = $conn->query($sql)) {
            if (!$result->num_rows > 0) {
                              
                return false;
            }
        }
        return true;
    }

    function fetch_profile($email) 
    {
        global $conn;
        $sql = "SELECT * FROM friends WHERE friend_email = '" . $email . "'; ";

        if ($result = $conn->query($sql)) 
        {
            $row = $result->fetch_assoc();

            return $row;
        } 
        return null;
    }

    function unfriend($user_id, $friend) {
        global $conn;
        $message = "";
        $sql = "DELETE FROM myfriends
                WHERE 
                    (friend_id1 = '" . $user_id . "' AND  friend_id2 = '" . $friend . "')
                OR 
                    (friend_id1 = '" . $friend . "' AND friend_id2 = '" . $user_id . "'); ";
        
        if (!$result = $conn->query($sql)) {
            $message = $message . "<p>Error(s) occurred!</p>";
        } else {
            $sql = "UPDATE friends 
                    SET num_of_friends = num_of_friends - 1 
                    WHERE friend_id = '" . $user_id . "';";
            
            if (!$result = $conn->query($sql)) {
                $message = $message . "<p>Error(s) occurred!</p>";
            } else {
                $message = $message . "<p>Unfriend successfully!</p>";
            }
        }
        return $message;
    }

    function add_friend($user_id, $friend) {
        global $conn;
        $msg = "";
        $sql = "INSERT INTO myfriends (friend_id1, friend_id2) 
                VALUES ('" . $user_id . "', '" . $friend . "'), 
                        ('" . $friend . "', '" . $user_id . "'); ";

        if (!($result = $conn->query($sql))) {
            $msg = $msg . "<p>Error!</p>";
        } else {
            $sql = "UPDATE friends 
                    SET num_of_friends = num_of_friends + 1
                    WHERE friend_id = '" . $user_id . "';";
            
            if (!($result = $conn->query($sql))) {
                $msg = $msg . "<p>Error</p>";
            } else {
                $msg = $msg . "Add Friend successfully!";
            }
        }
        header('Location: ./friendadd.php');
        return $msg;
    }

    function friend_suggestion($user_id, $offset, $limit, &$total_pages) {
        global $conn;
        $friend_suggestion = array(array());
        array_pop($friend_suggestion);
       
        $sql = "SELECT * FROM friends
                WHERE 
                    (NOT friend_id = '" . $user_id . "')
                AND
                    (friend_id NOT IN (
                        SELECT friend_id1 FROM myfriends
                        WHERE (myfriends.friend_id1 = '" . $user_id . "' OR myfriends.friend_id2 = '" . $user_id . "')
                    ));";           

        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                $total_rows = $result->num_rows;
                $total_pages = ceil($total_rows / $limit);

                $sql = "SELECT * FROM friends
                        WHERE 
                            (NOT friend_id = '" . $user_id . "')
                        AND
                            (friend_id NOT IN (
                                SELECT friend_id1 FROM myfriends
                                WHERE (myfriends.friend_id1 = '" . $user_id . "' OR myfriends.friend_id2 = '" . $user_id . "')
                            ))
                        LIMIT  $offset, $limit ; ";

                if ($res_data = $conn->query($sql)) {
                    while ($row = $res_data->fetch_assoc()) {
                        array_push($friend_suggestion, $row);
                    }
                }
                
            }
        }
        return $friend_suggestion;
    }

    function count_mutualfriends($user_id, $suggested_id) {
        global $conn;
        $sql = "SELECT count(*) as num_of_mutuals FROM (
                    SELECT friend_id2, count(*) as occurences FROM myfriends
                    WHERE (friend_id1 = '" . $user_id . "' OR friend_id1 = '" . $suggested_id . "')
                    GROUP BY friend_id2) src
                WHERE occurences > 1 ;";
        
        if ($result = $conn->query($sql)) {
            $row = $result->fetch_assoc();
            return $row['num_of_mutuals'];
        } else {
            return null;
        }
    }

    function get_friendlist($id) {
        global $conn;
        $friendlist = array(array());
        array_pop($friendlist);

        $sql = "SELECT myfriends.friend_id2 AS ID, friends.profile_name AS ProfileName 
                FROM myfriends 
                INNER JOIN friends ON myfriends.friend_id2 = friends.friend_id
                WHERE myfriends.friend_id1 = '" . $id . "';";
        
        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($friendlist, $row);
                }
            }
        } 
        return $friendlist;
    }

    // check if email exists and password match
    function password_check($password, $email) {
        global $conn;

        if (friend_email_exist($email)) {
            $sql = "SELECT friend_email, password FROM friends WHERE friend_email = '" . $email . "' AND password = '" . $password . "'; ";

            if ($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    return true;
                } else {
                    return false;  
                }
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
    }
?>