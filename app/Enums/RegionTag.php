<?php
namespace App\Enums;

enum RegionTag{
    const STATE = 'negeri';
    const PARLIMENT = 'parliment';
    const DUN = 'dun';

    public static function list() : array{
        return [
            RegionTag::STATE => RegionTag::STATE,
            RegionTag::PARLIMENT => RegionTag::PARLIMENT,
            RegionTag::DUN => RegionTag::DUN,
        ];
    }

    public static function badge($state) :string{
        return match($state){
            RegionTag::STATE => 'success',
            RegionTag::PARLIMENT => 'danger',
            RegionTag::DUN => 'warning',
        };
    }
}

?>