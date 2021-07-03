<?php

use App\Models\EmailLog;
use App\Models\GeneralSetting;
use App\Models\PaymentCredential;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (!function_exists('appDetails')) {
    function appDetails()
    {
        $app['name'] = 'Larasoft';
        $app['version'] = '1.0';
        return $app;
    }
}

if (!function_exists('modifyString')) {
    function modifyString($string, $delimeter)
    {
        $new = explode($delimeter, $string);
        $new = implode(" ", $new);
        return ucwords($new);
    }
}

if (!function_exists('path')) {
    function path($username = null)
    {
        $path['admin'] = [
            'path' => 'images/admin/profile',
            'size' => '800x800'
        ];

        $path['user'] = [
            'path' => 'images/user/profile',
            'size' => '800x800'
        ];

        $path['gateway'] = [
            'path' => 'images/gateway',
            'size' => '800x800'
        ];

        $path['logo'] = [
            'path' => 'images/app/logo',
            'size' => '100x100'
        ];

        $path['favicon'] = [
            'path' => 'images/app/favicon',
            'size' => '16x16'
        ];

        $path['video'] = [
            'tempPath' => 'videos' . "/" . $username . "/temp",
            'mainPath' => 'videos' . "/" . $username . "/" . Carbon::now()->format('Y-m-d H:i:s')
        ];

        return $path;
    }
}


if (!function_exists('uploadImage')) {
    function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
    {
        $path = makeDirectory($location);
        if (!$path) throw new Exception('File could not been created.');

        if ($old) {
            removeFile($location . '/' . $old);
            removeFile($location . '/thumb_' . $old);
        }
        $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file);
        if ($size) {
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
        }
        $image->save($location . '/' . $filename);

        if ($thumb) {
            $thumb = explode('x', $thumb);
            Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
        }

        return $filename;
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, $location, $size = null, $old = null)
    {
        $path = makeDirectory($location);
        if (!$path) throw new Exception('File could not been created.');

        if ($old) {
            removeFile($location . '/' . $old);
        }

        $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $file->move($location, $filename);
        return $filename;
    }
}

if (!function_exists('makeDirectory')) {
    function makeDirectory($path)
    {
        if (file_exists($path)) return true;
        return mkdir($path, 0755, true);
    }
}

if (!function_exists('removeFile')) {
    function removeFile($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }
}


if (!function_exists('email')) {
    function email($user, $subject, $message)
    {
        $templates = GeneralSetting::first();

        $text = str_replace("[name]", $user->name, $templates->email_template);
        $text = str_replace("[message]", $message, $text);

        $config = $templates->email_config;

        $log = new EmailLog();
        $log->user_id = $user->id;
        $log->mail_sender = $config->method;
        $log->from = $templates->appname . ' ' . $templates->email;
        $log->to = $user->email;
        $log->subject = $subject;
        $log->message = $text;
        $log->save();

        if ($config->method == 'php') {

            $headers = "From: $templates->appname - $templates->email> \r\n";
            $headers .= "Reply-To: $templates->appname - $templates->email> \r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
            @mail($user->email, $subject, $text, $headers);
        } else if ($config->method == 'smtp') {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = $config->host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $config->username;
                $mail->Password   = $config->password;
                if ($config->enc == 'ssl') {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                } else {
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                }
                $mail->Port       = $config->port;
                $mail->CharSet = 'UTF-8';
                //Recipients
                $mail->setFrom($templates->email, $templates->appname);
                $mail->addAddress($user->email, $user->name);
                $mail->addReplyTo($templates->email_from, $templates->appname);
                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $text;
                $mail->send();
            } catch (Exception $e) {
                throw new Exception($e);
            }
        }
    }
}

if (!function_exists('paymentCred')) {
    function paymentCred()
    {
        $cred = PaymentCredential::first();
        return $cred;
    }
}
