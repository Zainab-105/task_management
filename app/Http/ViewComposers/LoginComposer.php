<?php

namespace App\Http\ViewComposers;

use App\Models\Setting;
use Illuminate\View\View;

/**
 * To Manage View Details
 */
class LoginComposer
{
    protected array $sitesetting = [];

    public function __construct()
    {
        $this->sitesetting = Setting::pluck('value', 'constant')->toArray();
    }

    public function compose(View $view): void
    {
        $data = [
            'sitesetting' => $this->sitesetting,
        ];

        $view->with($data);
    }
}
