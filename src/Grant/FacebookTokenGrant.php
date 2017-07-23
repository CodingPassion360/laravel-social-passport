<?php

namespace CodingPassion360\LaravelSocialPassport\Grant;

class FacebookTokenGrant extends BaseTokenGrant
{
    /**
     * @var string
     */
    const GRANT_TYPE__FACEBOOK_TOKEN = 'facebook_token';

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return self::GRANT_TYPE__FACEBOOK_TOKEN;
    }

}
