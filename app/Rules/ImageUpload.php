<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageUpload implements Rule
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
        if ($value) {
            if (is_array($value)) {
                $name = array();
    
                foreach ($value as $val) {
                    array_push($name, $val->getClientOriginalName());
                }
    
                for ($i = 0; $i < count($name); $i++) { 
                    if (!is_numeric(pathinfo($name[$i], PATHINFO_FILENAME))) {
                        return false;
                    }
    
                    if (!strlen(pathinfo($name[$i], PATHINFO_FILENAME)) == 6) {
                        return false;
                    }
                }
    
                return true;
            } else {
                $name = $value->getClientOriginalName();
    
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nama file harus sesuai dengan nomor label terdaftar.';
    }
}
