<?php

namespace SocialNetwork\Models;

class AccountError
{
    const INVALID_USERNAME = 0;
    const INVALID_EMAIL = 1;
    const INVALID_PASSWORD = 2;
    const INVALID_PASSWORD_REPEAT = 3;
    const USERNAME_TAKEN = 4;
    const EMAIL_TAKEN = 5;
    const ACCOUNT_DOES_NOT_EXISTS = 6;
}
