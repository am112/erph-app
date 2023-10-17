<?php

namespace App\Enums;

enum UserType{
    const PM = 'pm';
    const PPMS = 'ppms';
    const SCHOOL = 'school';
    const ADMIN = 'admin';
    const SUPERVISOR = 'supervisor';

    public static function list() : array{
        return [
            UserType::PM => UserType::PM,
            UserType::PPMS => UserType::PPMS,
        ];
    }

    public static function badge($state) :string{
        return match($state){
            UserType::PM => 'success',
            UserType::PPMS => 'danger',
        };
    }

    public static function listRole() : array{
        return [
            UserType::SCHOOL => UserType::SCHOOL,
            UserType::SUPERVISOR => UserType::SUPERVISOR,
            UserType::ADMIN => UserType::ADMIN,
        ];
    }
}