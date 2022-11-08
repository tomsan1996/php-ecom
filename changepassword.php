<?php
require_once 'core/init.php';

$user = new User();
if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}
if(Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'currentPassword' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'new_password'
            )
        ));

        $currentPassword = Input::get('currentPassword');
        if($validation->passed()){
            if(!password_verify($currentPassword, $user->data()->password)){
                echo 'Your current password is wrong.';
            } else {
                try{
                    $user->update(array(
                        'password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)
                    ));
                    Session::flash('changepass', 'Your password has been changed.');
                    Redirect::to('index.php');
                } catch(Exception $e){
                    die($e->getMessage());
                }
            }
        } else {
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}

?>

<form action="" method="post">

    <div class="field">
        <label for="currentPassword">Current Password</label>
        <input type="password" name="currentPassword" id="currentPassword">
    </div>

    <div class="field">
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password">
    </div>

    <div class="field">
        <label for="new_password_again">Confirm New Password</label>
        <input type="password" name="new_password_again" id="new_password_again">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" value="Change Password">
</form>