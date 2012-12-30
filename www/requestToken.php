<?php
include __DIR__ . "/../vendor/autoload.php";

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Symfony\Component\HttpFoundation\RedirectResponse;

$client = new Client('https://api.twitter.com/{version}', array('version' => '1.1'));

$oauth = new OauthPlugin(array(
    'consumer_key'    => '***',
    'consumer_secret' => '***',
));

$client->addSubscriber($oauth);
$response = $client->post('/oauth/request_token')->send();

$oauth_token = $oauth_token_secret = $oauth_callback_confirmed = null;
parse_str((string)$response->getBody());

if ($response->getStatusCode() == 200 && $oauth_callback_confirmed == 'true') {
    $redirectResponse = new RedirectResponse("https://api.twitter.com/oauth/authenticate?" . http_build_query(array(
        'oauth_token' => $oauth_token)
    ), 302);
    $redirectResponse->send();
}
