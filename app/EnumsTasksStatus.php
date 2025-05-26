<?php

namespace App;

enum EnumsTasksStatus: string
{
    case TODO = 'toDo';
    case INPROGRESS = 'inProgress';
    case COMPLETED = 'completed';
}
