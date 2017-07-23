<?php

namespace CodingPassion360\LaravelSocialPassport\Constant;

class ConfigConstant
{
    /**
     * @var string
     */
    const CONFIG_NAME = 'social-passport';

    /**
     * @var string
     */
    const CONFIG_SOCIAL__GOOGLE = 'google';

    /**
     * @var string
     */
    const CONFIG_SOCIAL__FACEBOOK = 'facebook';

    /**
     * @var string
     */
    const CONFIG_ITEM__APP_ID = 'app_id';

    /**
     * @var string
     */
    const CONFIG_ITEM__APP_SECRET = 'app_secret';

    /**
     * @var string
     */
    const CONFIG_ITEM__APP_REDIRECT = 'app_redirect';

    /**
     * @var string
     */
    const CONFIG_ITEM__CREATE_IF_NOT_EXISTS = 'create_if_not_exists';

    /**
     * @var string
     */
    const CONFIG_ITEM__SOCIAL_ID_COLUMN = 'social_id_column';

    /**
     * @var string
     */
    const CONFIG_ITEM__SOCIAL_EMAIL_COLUMN = 'social_email_column';


    /**
     * @var string
     */
    const CONFIG_KEY__GOOGLE__APP_ID = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__GOOGLE . '.' . self::CONFIG_ITEM__APP_ID;

    /**
     * @var string
     */
    const CONFIG_KEY__GOOGLE__APP_SECRET = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__GOOGLE . '.' . self::CONFIG_ITEM__APP_SECRET;

    /**
     * @var string
     */
    const CONFIG_KEY__GOOGLE__APP_REDIRECT = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__GOOGLE . '.' . self::CONFIG_ITEM__APP_REDIRECT;

    /**
     * @var string
     */
    const CONFIG_KEY__GOOGLE__CREATE_IF_NOT_EXISTS = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__GOOGLE . '.' . self::CONFIG_ITEM__CREATE_IF_NOT_EXISTS;

    /**
     * @var string
     */
    const CONFIG_KEY__GOOGLE__SOCIAL_ID_COLUMN = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__GOOGLE . '.' . self::CONFIG_ITEM__SOCIAL_ID_COLUMN;

    /**
     * @var string
     */
    const CONFIG_KEY__GOOGLE__SOCIAL_EMAIL_COLUMN = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__GOOGLE . '.' . self::CONFIG_ITEM__SOCIAL_EMAIL_COLUMN;


    /**
     * @var string
     */
    const CONFIG_KEY__FACEBOOK__APP_ID = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__FACEBOOK . '.' . self::CONFIG_ITEM__APP_ID;

    /**
     * @var string
     */
    const CONFIG_KEY__FACEBOOK__APP_SECRET = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__FACEBOOK . '.' . self::CONFIG_ITEM__APP_SECRET;

    /**
     * @var string
     */
    const CONFIG_KEY__FACEBOOK__APP_REDIRECT = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__FACEBOOK . '.' . self::CONFIG_ITEM__APP_REDIRECT;

    /**
     * @var string
     */
    const CONFIG_KEY__FACEBOOK__CREATE_IF_NOT_EXISTS = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__FACEBOOK . '.' . self::CONFIG_ITEM__CREATE_IF_NOT_EXISTS;

    /**
     * @var string
     */
    const CONFIG_KEY__FACEBOOK__SOCIAL_ID_COLUMN = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__FACEBOOK . '.' . self::CONFIG_ITEM__SOCIAL_ID_COLUMN;

    /**
     * @var string
     */
    const CONFIG_KEY__FACEBOOK__SOCIAL_EMAIL_COLUMN = self::CONFIG_NAME . '.' . self::CONFIG_SOCIAL__FACEBOOK . '.' . self::CONFIG_ITEM__SOCIAL_EMAIL_COLUMN;

}
