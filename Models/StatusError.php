<?php

namespace SocialNetwork\Models;

class StatusError
{
    const REQUIRED_TEXT = 0;
    const TEXT_LIMIT_EXCEED = 1;
    const STATUS_DOES_NOT_EXIST = 2;
    const CAN_NOT_REPLY_ON_REPLY = 3;
    const NOT_YOUR_FRIEND = 4;
}
