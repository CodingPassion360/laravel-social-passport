<?php

namespace CodingPassion360\LaravelSocialPassport\Contracts;

interface SocialPassportUserInterface
{
    /**
     * Get User Id.
     *
     * @return string
     */
    public function getId();

    /**
     * Get Username.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get User Name or Display Name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get User Email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get the User Avatar Url.
     *
     * @return string
     */
    public function getAvatar();

}
