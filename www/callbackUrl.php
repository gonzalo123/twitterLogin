<?php
include __DIR__ . "/../vendor/autoload.php";

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$client = new Client('https://api.twitter.com/{version}', array('version' => '1.1'));

$oauth = new OauthPlugin(array(
    'consumer_key' => '***',
    'token'        => $request->get('oauth_token'),
    'verifier'     => $request->get('oauth_verifier'),
));

$client->addSubscriber($oauth);

try {
    $response    = $client->post('/oauth/access_token')->send();
    $oauth_token = $oauth_token_secret = $user_id = $screen_name = null;

    parse_str((string)$response->getBody());

    echo "<p>user_id = {$user_id}</p>";
    echo "<p>screen_name = {$screen_name}</p>";
} catch (Exception $e) {
    echo $e->getMessage();
}