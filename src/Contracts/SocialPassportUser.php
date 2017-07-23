<?php

namespace CodingPassion360\LaravelSocialPassport\Contracts;

abstract class SocialPassportUser implements SocialPassportUserInterface
{
    /**
     * The User Id.
     *
     * @var string
     */
    public $id;

    /**
     * The Username.
     *
     * @var string
     */
    public $username;

    /**
     * The User Name / Display Name.
     *
     * @var string
     */
    public $name;

    /**
     * The User Email.
     *
     * @var string
     */
    public $email;

    /**
     * The User Avatar Url.
     *
     * @var string
     */
    public $avatar;

    /**
     * The user's raw attributes.
     *
     * @var array
     */
    public $user;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

}
