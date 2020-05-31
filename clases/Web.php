<?php

class Web extends MySQL {

    public static function getTitle($id) {
        if (empty($id)) {
            $id = "index";
        }
        $id_parsed = str_replace("'", "", $id);
        $sql = "SELECT title FROM sections WHERE section='$id_parsed'";
        $query = self::query($sql);
        if (self::rowCount($query) > 0) {
            $ver = self::fetch($query);
            return $ver['title'];
        }
    }

    public static function getMetas($id) {
        if (empty($id)) {
            $id = "index";
        }
        $id_parsed = str_replace("'", "", $id);
        $sql = "SELECT seo.* FROM seo INNER JOIN sections AS sec ON sec.id = seo.section_id WHERE sec.section='$id_parsed'";
        $query = self::query($sql);
        if (self::rowCount($query) > 0) {
            $ver = self::fetchAll($query);
            $return = "";
            foreach ($ver as $v) {
                if (substr($v['tag'], 0, 3) == "og:") {
                    $tag = "property";
                } else {
                    $tag = "name";
                }
                $return .= '<meta ' . $tag . '="' . $v['tag'] . '" content="' . $v['content'] . '">' . "\n";
            }

            return $return;
        }
    }

    public static function isActive($sec, $id) {
        if (is_array($sec)) {
            if (in_array($id, $sec)) {
                return ' active';
            }
        } else {
            if ($sec == $id) {
                return ' class="active"';
            }
        }
    }

    public static function alerta($class, $title, $content) {
        $html = "<div class='alert alert-$class'>";

        $html .= "<h3>$title</h3><p>$content</p></div>";

        return $html;
    }

    public static function Redir($seconds, $url) {
        echo '<META HTTP-EQUIV=Refresh CONTENT="' . $seconds . '; URL=' . $url . '">';
    }

    public static function SendEmail($to, $subject, $body) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'YOUR_USERNAME';
        $mail->Password = 'YOUR_PASSWORD';
        $mail->SMTPSecure = 'tls';

        $mail->From = 'YOUR_USERNAME';
        $mail->FromName = 'UrbaLoca';
        $mail->AddAddress($to);

        $mail->IsHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
    }

}
