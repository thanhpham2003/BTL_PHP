<?php

namespace App\Http\Services\Info;

use App\Http\Repository\MenuRepository; 

class UserInfoService
{
    protected $menuRepository;
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

}