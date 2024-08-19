<?php

namespace Hellm\ToxicMvc\Constants;

class RegEx
{
    const INT = "\d+";
    const ALPHA_NUM = '[a-zA-Z0-9_-]+';
    const STRING_WITH_SPACES = '[a-zA-Z\s]+';
    const EMAIL = '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}';
    const UUID = '[a-fA-F0-9-]{36}';
    const DATE = '\d{4}-\d{2}-\d{2}';
    const TIME = '\d{2}:\d{2}:\d{2}';
    const PHONE = '\+?[0-9\s\-()]{7,}';
    const SLUG = '[a-z0-9]+(?:-[a-z0-9]+)*';
    const QUERY_PARAM = '[a-zA-Z0-9_\-]+';
}
