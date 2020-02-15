<?php
// api/src/Controller/CreateMediaObjectAction.php
namespace App\Controller;

use App\Entity\Users;
use App\Entity\Images;
use App\Algorithm\Algorithm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


final class ImageController extends AbstractController
{

    
    public function __invoke(Users $user)
{
    
    // Fetch content and determine boundary
$raw_data = file_get_contents('php://input');
//dd($raw_data);
$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
if($boundary==""){
    return $user;
}

// Fetch each part
$parts = array_slice(explode($boundary, $raw_data), 1);
$data = array();

foreach ($parts as $part) {
    // If this is the last part, break
    if ($part == "--\r\n") break; 

    // Separate content from headers
    $part = ltrim($part, "\r\n");
    list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

    // Parse the headers list
    $raw_headers = explode("\r\n", $raw_headers);
    $headers = array();
    foreach ($raw_headers as $header) {
        list($name, $value) = explode(':', $header);
        $headers[strtolower($name)] = ltrim($value, ' '); 
    } 
      // Parse the Content-Disposition to get the field name, etc.
      if (isset($headers['content-disposition'])) {
        $filename = null;
        preg_match(
            '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/', 
            $headers['content-disposition'], 
            $matches
        );
        list(, $type, $name) = $matches;
        isset($matches[4]) and $filename = $matches[4];

    }
    switch ($name) {
        // this is a file upload
        case 'userfile':
             (file_put_contents($filename, $body));
             break;

        // default for all other files is to populate $data
        default: 
             $data[$name] = substr($body, 0, strlen($body) - 2);
             break;
    } 
    $user->setImage(base64_encode($data["image"]));
    return $user;
   
    
}}

}