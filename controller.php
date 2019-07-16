<?php

$get = $_GET;
$post = $_POST;

if (is_array($get) && isset($get['action']))
{
    switch ($get['action'])
    {
        case 'getCites':
            getCites($get, $post);
            break;
        case 'addUser':
            addUser($get, $post);
            break;
        default :
            exit;
    }
}

function getCites($get, $post)
{
    $c_id = isset($post['c_id']) && (int) $post['c_id'] ? (int) $post['c_id'] : exit;
    require_once dirname(__FILE__).'/model.php';
    
    $db = new Model();
    $citys = $db->getCity($c_id);
    echo json_encode($citys);
    exit;   
}

function addUser($get, $post)
{    
    $login = isset($post['login']) ? trim($post['login']) : sendResult('error', 'Ошибка');
    
    $password = isset($post['password']) 
            && preg_match('|[A-Za-z0-9]{5,20}|', $post['password']) 
            ? trim($post['password']) 
            : sendResult('error', 'Ошибка');
    
    $phone = isset($post['phone']) 
            && preg_match('|[\+]?\d{0,2}\s?[\(]?\d{3}[\)]?\s?\d{3}[\-\|\s]\d{2}[\-\|\s]\d{2}|', $post['phone']) 
            ? trim($post['phone']) 
            : sendResult('error', 'Ошибка');
    
    $country = isset($post['country'])
            && (int) $post['country']
            ? (int) $post['country'] 
            : sendResult('error', 'Ошибка');
    
    $city = isset($post['city']) 
            && (int) $post['city']
            ? (int) $post['city'] 
            : sendResult('error', 'Ошибка');
    
    $invite = isset($post['invite']) 
            && preg_match('|[0-9]{6}|', $post['invite']) 
            ? (int) $post['invite'] 
            : sendResult('error', 'Ошибка');
    
    $phone = preg_replace('/\(|\)|\s|\+/', '', $phone, -1);
    
    require_once dirname(__FILE__).'/model.php';
    $db = new Model();
    $invite = $db->getInvaite($invite);
    $invite = $invite[0]->invite;    
    if ($invite)
    {
        if ($db->addUser($login, $password, $phone, $city, $invite))
        {
           $db->edditStatusInvite($invite); 
           sendResult('success', 'Ok');
        }
        
    }
    else sendResult('error', 'Ошибка');
    
}
function sendResult($status, $message)
{
    echo json_encode(array('status' => $status, 'message' => $message));
    exit;
}

