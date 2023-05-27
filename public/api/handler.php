<?php
#region CORS
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: content-type, token');
#endregion
#region CLASSES
class JWT
{
    static function encode($data, $key)
    {
        $header = base64_encode(json_encode(["typ" => "JWT", "alg" => "HS256"]));
        $payload = base64_encode(json_encode($data));
        $signature = base64_encode(hash_hmac("sha256", $header . "." . $payload, $key, true));
        return $header . "." . $payload . "." . $signature;
    }
    static function verify($jwt, $key)
    {
        $splited = explode(".", $jwt);
        return base64_encode(hash_hmac("sha256", $splited[0] . "." . $splited[1], $key, true)) == $splited[2];
    }
    static function data($jwt)
    {
        return json_decode(base64_decode(explode(".", $jwt)[1]));
    }
}
class DB
{
    public $db;
    public function __construct($db = "./admin.db")
    {
        $this->db = new PDO("sqlite:$db");
    }
    public function exec($qry, $vals = null)
    {
        $db = $this->db;
        if (!$db) return;
        $sth = $db->prepare($qry);
        if ($vals != null) for ($i = 1; $i <= count($vals); $i++) $sth->bindValue($i, $vals[$i - 1]);
        $ex = $sth->execute();
        if (substr(strtolower($qry), 0, 6) == "insert") $r = $db->lastInsertId();
        else if (substr(strtolower($qry), 0, 6) == "select") $r = $sth->fetchAll();
        else {
            if ($ex) $r = $sth->rowCount();
            else $r = null;
        }
        return $r;
    }
}
#endregion
$db = new DB();

$body = json_decode(file_get_contents("php://input"));
if (isset($_GET["o"])) {
    if ($_GET["o"] == "register") {
        $id = $db->exec(
            "insert into users (email, password, data) values (:1, :2, :3)",
            [$body->email, $body->password, "abc!@#"]
        );
        echo JWT::encode(["id" => $id, "iat" => time(), "role" => 0], "abc!@#");
    } else if ($_GET["o"] == "login") {
        $user = $db->exec(
            "select * from users where email = :1 and password = :2",
            [$body->email, $body->password]
        );
        if (count($user) == 1) {
            echo JWT::encode(["id" => $user[0]["id"], "iat" => time(), "role" => 0], "abc!@#");
        }
    } else {
        if (isset($_SERVER["HTTP_TOKEN"])) {
            $token = $_SERVER["HTTP_TOKEN"];








            $user_id = JWT::data($token)->id;
            if (!JWT::verify($token, $db->exec("select data from users where id = :1", [$user_id])[0]["data"])) die("not verified");
            else if (JWT::data($token)->iat < time() - 60 * 60) die("token expired, renew");
            if ($_GET["o"] == "addpost" && JWT::data($token)->role == 0) {
                $target = rand_str() . "_" . $_FILES["image"]["name"];
                $db->exec(
                    "insert into products (name, price, image, desc) values (:1, :2, :3, :4)",
                    [
                        json_decode($_POST["data"])->name,
                        json_decode($_POST["data"])->price,
                        $target,
                        json_decode($_POST["data"])->desc
                    ]
                );
                move_uploaded_file($_FILES["image"]["tmp_name"],  "../data/" . $target);
            }
        } else {
            if ($_GET["o"] == "getpost") {
                if (isset($_GET["id"]))
                    echo json_encode($db->exec("select * from products where id = :1", [$_GET["id"]])[0]);
                else
                    echo json_encode($db->exec("select * from products"));
            }
        }
    }
}
function rand_str()
{
    return base_convert(random_int(0, 1024 ** 6), 10, 16);
}
