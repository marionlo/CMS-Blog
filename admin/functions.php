<?php 

// DATABASE HELPERS FUNCTIONS

function confirm($result) {
    global $connection; 
    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function redirect($location) {
    header("Location: " . $location);
    exit;
}

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function query($query) {
    global $connection;
    $result = mysqli_query($connection, $query);
    confirm($result);
    return $result;
}

function fetchRecords($result) {
    return mysqli_fetch_array($result);
}

function count_records($result){
    return mysqli_num_rows($result);
}

// DATABASE HELPERS FUNCTIONS END

// GENERAL HELPERS

function get_username() {
   return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}


// AUTH HELPER
function is_admin() {
     
    if(isLoggedIn()) {
        $result = query("SELECT user_role FROM users WHERE user_id =" .$_SESSION['user_id']."");
        $row = fetchRecords($result);
        if($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    } return false;
}





function ifItIsMethod($method=null) {
    if($_SERVER['REQUEST_METHOD'] === strtoupper($method)) {
        return true;
    }

    return false;  
}

function isLoggedIn() {
    if(isset($_SESSION['user_role'])) {
        return true;
    }

        return false;
}

function loggedInUserId() {
    global $connection;
    if(isLoggedIn()) {
        $result = mysqli_query($connection, "SELECT * FROM users WHERE username ='" . $_SESSION['username'] ."'");
        confirm($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >=1 ? $user['user_id'] : false;
    }
}

function userLikePost($post_id = ''){
    global $connection;
    $result = mysqli_query($connection, "SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id=$post_id");
    confirm($result);
    return mysqli_num_rows($result) >=1 ? true : false;
}

function fetchLikes($post_id) {
    global $connection;
    $result = mysqli_query($connection, "SELECT * FROM likes WHERE post_id = $post_id");
    confirm($result);
    echo mysqli_num_rows($result);
}

function checkIfUserLoggedInAndRedirect($redirectLocation=null) {
    if(isLoggedIn()) {
        redirect($redirectLocation);
    }
}

// Displays the data for the panels on the index of the Dashboard
function recordCount($table) {
    global $connection;
    $query = "SELECT * FROM " . $table;
    $send_all_posts = mysqli_query($connection, $query);
    $result = mysqli_num_rows($send_all_posts);
    confirm($result);
    return $result;
}

// FETCH DATA FOR THE INDEX DASHBOARD PAGE

// Displays the data for the panels on the index of the Dashboard for a specific user
function get_all_user_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()."");
}

function get_all_posts_user_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()."");

}

function get_all_user_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}

function get_all_user_published_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='published'");
}

function get_all_user_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status='draft'");
}

function get_all_user_approved_posts_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()." AND comment_status='approved'");
}


function get_all_user_unapproved_posts_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()." AND comment_status='unapproved'");
}




// Displays the data for the graph on the index of the Dashboard
function checkStatus($table, $columnName, $status) {
    global $connection;
    $query = "SELECT * FROM $table WHERE $columnName = '$status' ";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);

}


// Add a category feature 
function insert_categories() {
                global $connection;
                 if(isset($_POST['submit'])) {
                $cat_title = $_POST['cat_title'];  
                if($cat_title == "" || empty($cat_title)) {
                echo "This field should not be empty";
                } else {
                $user_id = loggedInUserId();
                $stmt = mysqli_prepare($connection,"INSERT INTO categories(cat_title,user_id) VALUES(?,?) ");
                mysqli_stmt_bind_param($stmt, 'si',$cat_title,$user_id);
                mysqli_stmt_execute($stmt);
                if(!$stmt) {
                die('QUERY FAILED' . mysqli_error($connection));
                header("Location: categories.php");  
                 }   
            }
        }
    }

function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);     
     while($row = mysqli_fetch_assoc($select_categories )) {
     $cat_title = $row['cat_title'];
     $cat_id = $row['cat_id'];
     echo "<tr>";
     echo "<td>{$cat_id}</td>";   
     echo "<td>{$cat_title}</td>";
     echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'>Delete</a></td>";
     echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-info'>Edit</a></td>";
     echo "</tr>";
}

}


function findAllUserCategories() {
    global $connection;
    $query = "SELECT * FROM categories WHERE user_id=".loggedInUserId()."";
    $select_categories = mysqli_query($connection, $query);     
     while($row = mysqli_fetch_assoc($select_categories )) {
     $cat_title = $row['cat_title'];
     $cat_id = $row['cat_id'];
     echo "<tr>";
     echo "<td>{$cat_id}</td>";   
     echo "<td>{$cat_title}</td>";
     echo "<td><a href='categories.php?delete={$cat_id}' class='btn btn-danger'>Delete</a></td>";
     echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-info'>Edit</a></td>";
     echo "</tr>";
}

}

function deleteCategories() {
    global $connection;
    if(isset($_GET['delete'])) {
        $the_cat_id = escape($_GET['delete']);
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php"); //This will refresh the page
    }
}

function findAllComments() {
    global $connection;
    $query = "SELECT * FROM comments";
    $select_comments = mysqli_query($connection, $query);     
    while($row = mysqli_fetch_assoc($select_comments)) {
    $comment_id = $row['comment_id'];
    $comment_author = $row['comment_author'];
    $comment_post_id = $row['comment_post_id'];
    $comment_email = $row['comment_email'];
    $comment_date = $row['comment_date'];
    $comment_content = $row['comment_content'];
    $comment_status = $row['comment_status'];
    echo "<tr>";
    echo "<td>{$comment_id}</td>";   
    echo "<td>{$comment_author}</td>";
    echo "<td>{$comment_content}</td>";
    echo "<td>{$comment_email}</td>";
    echo "<td>{$comment_status}</td>";

    // Add the post title for each comment
    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
    $select_post_id = mysqli_query($connection, $query);     
    while($row = mysqli_fetch_assoc($select_post_id)) {
    $post_title = $row['post_title'];
    $post_id = $row['post_id'];
    echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
    }
    echo "<td>{$comment_date}</td>";
    echo "<td><a href='comments.php?approve={$comment_id}' class='btn btn-success'>Approve</a></td>"; 
    echo "<td><a href='comments.php?unapprove={$comment_id}' class='btn btn-warning'>Unapprove</a></td>";  
    echo "<td><a href='comments.php?delete={$comment_id}' class='btn btn-danger'>Delete</a></td>";  
    echo "</tr>";
}
}

function deleteComment() {
    global $connection;
    if(isset($_GET['delete'])) {
        // Prevent people from deleting when they are not logged in
           if(isset($_SESSION['user_role'])) {
           if($_SESSION['user_role'] == 'admin') {
       $the_comment_id = mysqli_real_escape_string($connection, $_GET['delete']);
       $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
       $delete_query = mysqli_query($connection, $query);
       $query2 = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
       $query2 .= "WHERE post_id = $comment_post_id ";
       $update_query = mysqli_query($connection,$query2);
       header("Location: comments.php"); //This will refresh the page
   }
}
}
}


function approveComment() {
    global $connection;
    if(isset($_GET['approve'])) {
        // Prevent people from approving when they are not logged in
           if(isset($_SESSION['user_role'])) {
           if($_SESSION['user_role'] == 'admin') {
       $the_comment_id = mysqli_real_escape_string($connection, $_GET['approve']);
       $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
       $unapprove_query = mysqli_query($connection, $query);
       header("Location: comments.php"); //This will refresh the page
    }
    }
}
}

function unapproveComment() {
    global $connection;
    if(isset($_GET['unapprove'])) {
        // Prevent people from unapproving when they are not logged in
           if(isset($_SESSION['user_role'])) {
           if($_SESSION['user_role'] == 'admin') {
       $the_comment_id = mysqli_real_escape_string($connection, $_GET['unapprove']);
       $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
       $unapprove_query = mysqli_query($connection, $query);
       header("Location: comments.php"); //This will refresh the page
    }
    }
}
}



function username_exists($username){
    global $connection;
    $query ="SELECT username FROM users WHERE username ='$username' ";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function email_exists($email){
    global $connection;
    $query ="SELECT user_email FROM users WHERE user_email ='$email' ";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function register_user($username, $email, $password) {
    global $connection;

    // Escape the values
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12) );

    
    // Fetch our DB

    $query = "INSERT INTO users (username, user_email, password, user_role) ";
    $query .= "VALUES ('$username', '$email', '$password', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);

    confirm($register_user_query);

     
}

function login_user($username, $password) {
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '$username' ";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query) {
        die('Query Failed' . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_user_password = $row['password'];

        if(password_verify($password, $db_user_password)) {
            $_SESSION['user_id'] =  $db_user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
    
            redirect("/cms/admin");
    
        } else {
            return false;
        }
        
    }
  

}


function users_online() {
    if(isset($_GET['onlineusers'])) {
        global $connection;
    if(!$connection) {
        session_start();
        include("../includes/db.php");

        $session = session_id();
        // time_out checks for the users that were logged in the last 60 seconds
        $time = time();
        $time_out_in_seconds = 60;
        $time_out = $time - $time_out_in_seconds;
        // Count if anybody is online
        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);
        
        if($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session','$time')");
        } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }
        // Count the number of users online
        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_users = mysqli_num_rows($users_online_query);
         }  
    
    } // Get request isset
}

users_online()




?>