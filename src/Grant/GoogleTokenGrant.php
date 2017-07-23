<?php

namespace CodingPassion360\LaravelSocialPassport\Grant;

class GoogleTokenGrant extends BaseTokenGrant
{
    /**
     * @var string
     */
    const GRANT_TYPE__FACEBOOK_TOKEN = 'google_token';

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return self::GRANT_TYPE__FACEBOOK_TOKEN;
    }

}
