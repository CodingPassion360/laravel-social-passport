<?php

namespace CodingPassion360\LaravelSocialPassport\Providers;

use CodingPassion360\LaravelSocialPassport\Constant\ConfigConstant;
use CodingPassion360\LaravelSocialPassport\Grant\FacebookTokenGrant;
use CodingPassion360\LaravelSocialPassport\Grant\GoogleTokenGrant;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;

class SocialPassportServiceProvider extends PassportServiceProvider
{
    /**
     * The config file name.
     *
     * @var string
     */
    const CONFIG_FILE_NAME = ConfigConstant::CONFIG_NAME . '.php';

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath() => config_path(self::CONFIG_FILE_NAME)
        ]);

        /* Enable GrantType for SocialPassport. */
        app(AuthorizationServer::class)->enableGrantType($this->makeGooglePassportGrant(), Passport::tokensExpireIn());
        app(AuthorizationServer::class)->enableGrantType($this->makeFacebookPassportGrant(), Passport::tokensExpireIn());
    }

    protected function configPath()
    {
        return __DIR__ . '/../Config/' . self::CONFIG_FILE_NAME;
    }

    /**
     * Create Google GrantType.
     *
     * @return PasswordGrant
     */
    protected function makeGooglePassportGrant()
    {
        $grant = new GoogleTokenGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

    /**
     * Create Facebook GrantType.
     *
     * @return PasswordGrant
     */
    protected function makeFacebookPassportGrant()
    {
        $grant = new FacebookTokenGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }

}
