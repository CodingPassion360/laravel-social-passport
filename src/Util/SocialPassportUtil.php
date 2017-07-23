<?php

namespace CodingPassion360\LaravelSocialPassport\Util;

use CodingPassion360\LaravelSocialPassport\Users\FacebookPassportUser;
use CodingPassion360\LaravelSocialPassport\Users\GooglePassportUser;
use Facebook\Facebook;

class SocialPassportUtil
{
    /**
     * @param string $appId
     * @param string $appSecret
     * @param string $redirectUri
     * @param string $socialToken
     *
     * @return GooglePassportUser|null
     */
    public static function getGoogleUser($appId, $appSecret, $redirectUri, $socialToken)
    {
        $googleClient = new \Google_Client([
            'client_id' => $appId,
            'client_secret' => $appSecret,
            'redirect_uri' => $redirectUri,
        ]);

        // Verify Google Id Token.
        $payload = $googleClient->verifyIdToken($socialToken);

        if (!$payload) {
            return null;
        }

        // Build the Passport User.
        $googlePassportUser = new GooglePassportUser();

        if (array_key_exists('sub', $payload)) {
            $googlePassportUser->id = $payload['sub'];
        }

        if (array_key_exists('email', $payload)) {
            $googlePassportUser->email = $payload['email'];
        }

        if (array_key_exists('name', $payload)) {
            $googlePassportUser->name = $payload['name'];
        }

        if (array_key_exists('picture', $payload)) {
            $googlePassportUser->avatar = $payload['picture'];
        }

        return $googlePassportUser;
    }

    /**
     * @param string $appId
     * @param string $appSecret
     * @param string $socialToken
     * @param bool $requireEmail
     *
     * @return FacebookPassportUser|null
     */
    public static function getFacebookUser($appId, $appSecret, $socialToken, $requireEmail = true)
    {
        // Create Facebook object.
        $facebook = new Facebook([
            'app_id' => $appId,
            'app_secret' => $appSecret,
        ]);

        $facebook->setDefaultAccessToken($socialToken);

        /* Get Facebook User information. */
        if ($requireEmail) {
            $facebookResponse = $facebook->get('/me?fields=id,email,name,picture.type(normal)');
        } else {
            $facebookResponse = $facebook->get('/me?fields=id,name,picture.type(normal)');
        }

        $facebookUser = $facebookResponse->getDecodedBody();

        if (!$facebookUser) {
            return null;
        }

        // Build the Passport User.
        $facebookPassportUser = new FacebookPassportUser();

        if (array_key_exists('id', $facebookUser)) {
            $facebookPassportUser->id = $facebookUser['id'];
        }

        if (array_key_exists('email', $facebookUser)) {
            $facebookPassportUser->email = $facebookUser['email'];
        }

        if (array_key_exists('name', $facebookUser)) {
            $facebookPassportUser->name = $facebookUser['name'];
        }

        if (array_key_exists('picture', $facebookUser)) {
            $picture = $facebookUser['picture'];

            if (is_array($picture) && array_key_exists('data', $picture)) {
                $pictureData = $picture['data'];

                if (is_array($pictureData) && array_key_exists('url', $pictureData)) {
                    $facebookPassportUser->avatar = $pictureData['url'];
                }
            }

        }

        return $facebookPassportUser;
    }

}
