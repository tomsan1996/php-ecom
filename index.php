<?php

require_once 'core/init.php';

if(Session::exists('home')){
    echo Session::flash('home');
}
if(Session::exists('profileupdate')){
    echo Session::flash('profileupdate');
}
if(Session::exists('changepass')){
    echo Session::flash('changepass');
}

$user = new User();
if($user->isLoggedIn()){
    if(Session::exists('login')){
        echo Session::flash('login');
    }
?> <p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username);?></a>!</p>   
    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Update details</a></li>
        <li><a href="changepassword.php">Change password</a></li>
    </ul> 
<?php

if($user->hasPermission('admin')){
    echo '<p>You are an administrator.</p>';
}

}else {
    echo '<p>You need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}

?>