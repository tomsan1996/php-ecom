<?php
require_once 'core/init.php';




if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required'=> true),
            'password' => array('required'=> true)
        ));
        if($validation->passed()){
            // Log user in

            $user = new User();
            $remember = (Input::get('remember') == '1') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);
            if($login){
                Session::flash("login", "You have been logged in");
                Redirect::to('index.php');
            }
        } else {
            echo 'Sorry, login in failed.</br>';
           
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}

if(Session::exists('wronguserpass')){
    echo Session::flash('wronguserpass');
}

?>


<form action="" method ="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password"  id="password">
    </div>
    <div class="field">
        <input type="checkbox" name="remember" value='1' id="remember">
        <label for="remember">Remember me</label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" value="Log In">
</form>