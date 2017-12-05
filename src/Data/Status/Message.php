<?php

namespace NHDS\Jobs\Data\Status;

class Message
{
    const TABLE_NAME                 = 'nhds_status_message';
    const FIELD_NAME_ID              = 'nhds_status_message_id';
    const FIELD_NAME_STATUS_ID       = 'nhds_status_id';
    const FIELD_NAME_DATETIME        = 'datetime';
    const FIELD_NAME_MICROTIME       = 'microtime';
    const FIELD_NAME_LEVEL           = 'level';
    const FIELD_NAME_MESSAGE         = 'message';
    const INDEX_NAME_STATUS_ID       = 'STATUS_ID';
    const FOREIGN_KEY_NAME_STATUS_ID = 'STATUS_ID';
}