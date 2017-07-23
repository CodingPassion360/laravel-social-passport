<?php

namespace CodingPassion360\LaravelSocialPassport\Traits;

use CodingPassion360\LaravelSocialPassport\Constant\ConfigConstant;
use CodingPassion360\LaravelSocialPassport\Constant\GrantTypeConstant;
use CodingPassion360\LaravelSocialPassport\Users\FacebookPassportUser;
use CodingPassion360\LaravelSocialPassport\Users\GooglePassportUser;
use CodingPassion360\LaravelSocialPassport\Util\SocialPassportUtil;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;

trait SocialPassport
{
    /**
     * Find User using SocialPassport architecture.
     *
     * @param $socialToken
     * @param $grantType
     * @param ServerRequestInterface $request
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     */
    public function findBySocialPassport($socialToken, $grantType, ServerRequestInterface $request)
    {
        switch ($grantType) {
            case GrantTypeConstant::GOOGLE:
                // Get config information.
                $appId = config(ConfigConstant::CONFIG_KEY__GOOGLE__APP_ID, '');
                $appSecret = config(ConfigConstant::CONFIG_KEY__GOOGLE__APP_SECRET, '');
                $appRedirect = config(ConfigConstant::CONFIG_KEY__GOOGLE__APP_REDIRECT, '');

                // Get Google Passport User.
                $googlePassportUser = SocialPassportUtil::getGoogleUser($appId, $appSecret, $appRedirect, $socialToken);

                if (!$googlePassportUser || !$googlePassportUser->getId()) {
                    throw OAuthServerException::serverError('Cannot get Google user profile!');
                }

                // Find User.
                $user = $this->findByGooglePassport($googlePassportUser, $request);

                if ($user != null) {
                    // Allow update the information.
                    if (method_exists($user, 'updateByGooglePassport')) {
                        return $user->updateByGooglePassport($googlePassportUser, $request);
                    }
                } else {
                    $createIfNotExists = config(ConfigConstant::CONFIG_KEY__GOOGLE__CREATE_IF_NOT_EXISTS, false);

                    if ($createIfNotExists) {
                        $user = $this->createByGooglePassport($googlePassportUser, $request);
                    }
                }

                return $user;
            case GrantTypeConstant::FACEBOOK:
                // Get config information.
                $appId = config(ConfigConstant::CONFIG_KEY__FACEBOOK__APP_ID, '');
                $appSecret = config(ConfigConstant::CONFIG_KEY__FACEBOOK__APP_SECRET, '');

                // Get Facebook Passport User.
                $facebookPassportUser = SocialPassportUtil::getFacebookUser($appId, $appSecret, $socialToken);

                if (!$facebookPassportUser || !$facebookPassportUser->getId()) {
                    throw OAuthServerException::serverError('Cannot get Facebook user profile!');
                }

                // Find User.
                $user = $this->findByFacebookPassport($facebookPassportUser, $request);

                if ($user != null) {
                    // Allow update the information.
                    if (method_exists($user, 'updateByFacebookPassport')) {
                        return $user->updateByFacebookPassport($facebookPassportUser, $request);
                    }
                } else {
                    $createIfNotExists = config(ConfigConstant::CONFIG_KEY__FACEBOOK__CREATE_IF_NOT_EXISTS, false);

                    if ($createIfNotExists) {
                        $user = $this->createByFacebookPassport($facebookPassportUser, $request);
                    }
                }

                return $user;
            default:
                throw OAuthServerException::invalidGrant('Unknown GrantType: ' . $grantType);
        }

    }

    /**
     * Find User by Google Passport information.
     *
     * @param GooglePassportUser $googlePassportUser
     * @param ServerRequestInterface $request
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws OAuthServerException
     */
    public function findByGooglePassport(GooglePassportUser $googlePassportUser, ServerRequestInterface $request)
    {
        try {
            // Get config information.
            $provider = config('auth.guards.api.provider');
            $userModel = config('auth.providers.' . $provider . '.model');
            $socialIdColumn = config(ConfigConstant::CONFIG_KEY__GOOGLE__SOCIAL_ID_COLUMN, '');

            $user = $userModel::where($socialIdColumn, $googlePassportUser->getId())->first();

            if ($user) {
                // If the Updating method exists, then call that method.
                if (method_exists($userModel, 'updateByGooglePassport')) {
                    return $user->updateByGooglePassport($googlePassportUser, $request);
                }
            }

            return $user;
        } catch (\Exception $exception) {
            throw OAuthServerException::serverError($exception->getMessage());
        }
    }

    /**
     * Find User by Facebook token.
     *
     * @param FacebookPassportUser $facebookPassportUser
     * @param ServerRequestInterface $request
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws OAuthServerException
     */
    public function findByFacebookPassport(FacebookPassportUser $facebookPassportUser, ServerRequestInterface $request)
    {
        try {
            // Get config information.
            $provider = config('auth.guards.api.provider');
            $userModel = config('auth.providers.' . $provider . '.model');
            $socialIdColumn = config(ConfigConstant::CONFIG_KEY__FACEBOOK__SOCIAL_ID_COLUMN, '');

            $user = $userModel::where($socialIdColumn, $facebookPassportUser->getId())->first();

            return $user;
        } catch (\Exception $exception) {
            throw OAuthServerException::serverError($exception->getMessage());
        }
    }

    /**
     * Create User by Google Passport information.
     *
     * @param GooglePassportUser $googlePassportUser
     * @param ServerRequestInterface $request
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws OAuthServerException
     */
    public function createByGooglePassport(GooglePassportUser $googlePassportUser, ServerRequestInterface $request)
    {
        try {
            // Get config information.
            $provider = config('auth.guards.api.provider');
            $userModel = config('auth.providers.' . $provider . '.model');
            $socialIdColumn = config(ConfigConstant::CONFIG_KEY__GOOGLE__SOCIAL_ID_COLUMN, '');
            $socialEmailColumn = config(ConfigConstant::CONFIG_KEY__GOOGLE__SOCIAL_EMAIL_COLUMN, '');

            // Create User from basic information.
            $user = $userModel::create([
                $socialIdColumn => $googlePassportUser->getId(),
                $socialEmailColumn => $googlePassportUser->getEmail(),
                // 'password' => '',
            ]);

            return $user;
        } catch (\Exception $exception) {
            throw OAuthServerException::serverError($exception->getMessage());
        }
    }

    /**
     * Create User by Facebook Passport information.
     *
     * @param FacebookPassportUser $facebookPassportUser
     * @param ServerRequestInterface $request
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws OAuthServerException
     */
    public function createByFacebookPassport(FacebookPassportUser $facebookPassportUser, ServerRequestInterface $request)
    {
        try {
            // Get config information.
            $provider = config('auth.guards.api.provider');
            $userModel = config('auth.providers.' . $provider . '.model');
            $socialIdColumn = config(ConfigConstant::CONFIG_KEY__FACEBOOK__SOCIAL_ID_COLUMN, '');
            $socialEmailColumn = config(ConfigConstant::CONFIG_KEY__FACEBOOK__SOCIAL_EMAIL_COLUMN, '');

            // Create User from basic information.
            $user = $userModel::create([
                $socialIdColumn => $facebookPassportUser->getId(),
                $socialEmailColumn => $facebookPassportUser->getEmail(),
                // 'password' => '',
            ]);

            return $user;
        } catch (\Exception $exception) {
            throw OAuthServerException::serverError($exception->getMessage());
        }
    }

}
