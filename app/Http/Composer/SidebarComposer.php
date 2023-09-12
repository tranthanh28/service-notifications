<?php

namespace App\Http\Composer;

use App\Models\Core\Builder\Table\CustomTable;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        $table = CustomTable::all();

        $menu = [
            [
                'icon' => 'pie-chart',
                'name' => 'Update Reaction',
                'url' => request()->root() . '/reaction',
                'permission' => true
            ],
            [
                'icon' => 'user-check',
                'name' => trans('custom.user_and_roles'),
                'url' => request()->root() . '/users-and-roles',
                'permission' => authorize_any(['view_users', 'view_roles', 'invite_user', 'create_roles']),
            ],
        ];


        $view->with(['data' => $menu]);
    }
}
