<?php

use App\Helpers\Token;

include_once BASE_DIR . "/app/helpers/generate_ref_number.php";
/**
 * @param string $path a path to be redirected to. eg: '/login'
 */
function redirect_to($path)
{
    // header("location:" . $path);
    echo '<script>location="' . $path . '"</script>';
    return;
}

function url_path($route)
{
    if (substr($route, 0, 1) !== '/') {
        $route = '/' . $route;
    }
    return ROOT_URL . $route;
}

function is_auth()
{
    return isset($_SESSION['userdata']);
}

function is_guest()
{
    return is_auth();
}


/**
 * flashes a temporally message using session variables
 */
function flash($message)
{
    $_SESSION['message'] = $message;
    return;
}

function flash_show()
{
    if (isset($_SESSION['message'])) {
        foreach ($_SESSION['message'] as $key => $value) {
            alert($value, $key);
            unset($_SESSION['message'][$key]);
        }
    }
}

/**
 * display a message
 */
function alert($message, $type = null)
{
    $alert_class = "primary";
    if ($type === "error") $alert_class = "danger";
    elseif ($type === 'success') $alert_class = "success";
    elseif ($type === 'info') $alert_class = "info";
    elseif ($type === 'warn') $alert_class = "warning";

    echo "<div class='alert alert-$alert_class text-center alert-dismissible'>
			<button type='button' title='dismiss' class='close'>&times;</button>
		    " . ucwords($message) . "
        </div>
        ";
    return;
}

/**
 * checks whether there is a flash message stored into the session
 * @param string $field_name the name of the key to look for
 * @param string $key the second key, just in case the session holds a multi-dimension array, make it null for a single dim array 
 */
function has($field_name, $key = 'message')
{
    if ($key == null) {
        return isset($_SESSION[$field_name]);
    }
    return isset($_SESSION[$key][$field_name]);
}

function get_user()
{
    if (is_auth()) {
        return $_SESSION['userdata'][0];
    } else {
        return [];
    }
}

function csrf_token()
{
    echo "<input type=\"hidden\" name=\"csrf_token\" value=\"" . Token::generate() . "\">";
}

/** 
 * @param string $password 
 * @return string Hashed version of the password
 * */
function hash_password($password)
{
    return md5($password);
}
