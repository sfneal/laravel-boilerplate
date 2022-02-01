<?php

namespace Domain\Landing\Controllers;

use Domain\Landing\ViewModels\LandingViewModel;
use Illuminate\Http\Request;
use Sfneal\Controllers\Controller;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     *
     * @param  Request  $request
     * @return string
     */
    public function __invoke(Request $request): string
    {
        return (new LandingViewModel())
            ->dontCacheInDevelopment()
            ->render();
    }
}
