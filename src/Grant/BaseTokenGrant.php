<?php

namespace CodingPassion360\LaravelSocialPassport\Grant;

use Laravel\Passport\Bridge\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\RequestEvent;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

class BaseTokenGrant extends PasswordGrant
{
    /**
     * @var string
     */
    const PARAM__SOCIAL_TOKEN = 'social_token';

    /**
     * The method name: 'findBySocialPassport'.
     *
     * @var string
     */
    const METHOD_NAME__FIND_BY_SOCIAL_PASSPORT = 'findBySocialPassport';

    /**
     * {@inheritdoc}
     */
    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client)
    {
        $socialToken = $this->getRequestParameter(self::PARAM__SOCIAL_TOKEN, $request);

        if (is_null($socialToken)) {
            throw OAuthServerException::invalidRequest(self::PARAM__SOCIAL_TOKEN);
        }

        $user = $this->getUserEntityBySocialToken($socialToken, $this->getIdentifier(), $request, $client);

        if ($user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidCredentials();
        }

        return $user;
    }

    /**
     * Get User entity from SocialToken.
     *
     * @param $socialToken
     * @param $grantType
     * @param ServerRequestInterface $request
     * @param ClientEntityInterface $clientEntity
     *
     * @return User|null
     * @throws OAuthServerException
     */
    protected function getUserEntityBySocialToken($socialToken, $grantType, ServerRequestInterface $request, ClientEntityInterface $clientEntity)
    {
        $provider = config('auth.guards.api.provider');

        if (is_null($model = config('auth.providers.' . $provider . '.model'))) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }

        if (!method_exists($model, self::METHOD_NAME__FIND_BY_SOCIAL_PASSPORT)) {
            throw OAuthServerException::serverError('The method in the User model is not found: ' . self::METHOD_NAME__FIND_BY_SOCIAL_PASSPORT);
        }

        // Todo: take note when change the method name according to METHOD_NAME__FIND_BY_SOCIAL_PASSPORT constant.
        $user = (new $model)->findBySocialPassport($socialToken, $grantType, $request);

        if (!$user) {
            return null;
        } else {
            return new User($user->getAuthIdentifier());
        }
    }

}
