<?php

namespace App\Enums;

enum Role: string
{
    case Pengguna = 'pengguna';
    case Supervisor = 'supervisor';
    case Admin = 'admin';
}