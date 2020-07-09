<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;


class ScriptsController extends Controller
{
    // SSH to a server
    public function actionSsh($host, $port, $username, $password="") {
        
        try {
            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $username, $password);
            $stream = ssh2_exec($connection, '/usr/bin/php -i');
        } catch (\yii\base\ErrorException $e) {
            print_r('Exception: ' . $e->getMessage(). "\n");
        }
    }

    // Check the disk usage
    public function actionDiskUsage($path="/") {
        echo "Disk Usage for Path - ".$path."\n";
        $bytes = disk_free_space($path);
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        echo $bytes . " Bytes". "\n";
        echo sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . "\n";
    }

    //Inode usage
    public function actionInodeUsage($filename) {
        echo "File inode of ". $filename ."\n";
        echo fileinode($filename) . "\n";
    }

    //list of files from the path
    public function actionFilesFromPath($dir) {
        // Open a directory, and read its contents
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
              echo "Filename:" . $file . "\n";
            }
            closedir($dh);
          }
        } else {
            echo "Not a valid directory. \n";
        }
    }

    //copy file to the remote server via FTP
    public function actionCopyfileViaFtp($ftp_server, $ftp_username, $ftp_password, $localFile, $remoteFile) {
        // connect and login to FTP server
        
        //$ftp_server = "ftp.example.com";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server \n");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

        //$file = "localfile.txt";

        // upload file
        if (ftp_put($ftp_conn, $remoteFile, $localFile, FTP_ASCII)) {
          echo "Successfully uploaded $localFile. \n";
        }
        else {
          echo "Error uploading $localFile. \n";
        }

        // close connection
        ftp_close($ftp_conn);
    }

    //copy file to the remote server via SCP
    public function actionCopyfileViaScp($hostname, $port, $username, $password, $localfile, $remotefile) {
        try {
            $connection = ssh2_connect($hostname, $port);
            ssh2_auth_password($connection, $username, $password);
        }  catch (\yii\base\ErrorException $e) {
            print_r('Exception: ' . $e->getMessage(). "\n");
        }        

        if(ssh2_scp_send($connection, $localfile, $remotefile, 0644)) {
            echo "File - " .$localfile. "copied to remote server Successfully. \n";
        } else {
            echo "Failed to copy - " .$localfile. " file to remote server. \n";
        }
    }

    //copy file to the remote server via SFTP
    public function actionCopyfileViaSftp($hostname, $port, $localFile, $remoteFile) {
        // Create connection the the remote host
        $conn = ssh2_connect($hostname, $port);

        // Create SFTP session
        $sftp = ssh2_sftp($conn);

        $sftpStream = @fopen('ssh2.sftp://'.$sftp.$remoteFile, 'w');

        try {

            if (!$sftpStream) {
                throw new Exception("Could not open remote file: $remoteFile \n");
            }
           
            $data_to_send = @file_get_contents($localFile);
           
            if ($data_to_send === false) {
                throw new Exception("Could not open local file: $localFile. \n");
            }
           
            if (@fwrite($sftpStream, $data_to_send) === false) {
                throw new Exception("Could not send data from file: $localFile. \n");
            }
           
            fclose($sftpStream);
                           
        } catch (\yii\base\ErrorException $e) {
            print_r('Exception: ' . $e->getMessage(). "\n");
            fclose($sftpStream);
        }
    }
}
