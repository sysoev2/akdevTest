<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Todo;
use App\Models\TodoList;
use App\Policies\TodoListPolicy;
use App\Policies\TodoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        TodoList::class => TodoListPolicy::class,
        Todo::class => TodoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
