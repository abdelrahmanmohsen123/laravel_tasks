<?php

namespace App\Rules;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\InvokableRule;

class CheckUserCreateExceed3Posts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    public function __invoke(string $attribute, mixed $value, Closure $fail): void
    {
        // $user_info = DB::table('posts')
        //          ->select('post_creator', DB::raw('count(*) as total'))
        //          ->groupBy('post_creator')
        //          ->count();
        // dd($user_info);
        if (strtoupper($value) !== $value) {
            $fail('The :attribute must be uppercase.');
        }
    }
}