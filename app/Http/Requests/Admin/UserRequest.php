<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserRequest",
 *     required={"name", "password", "status", "email"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the user."
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="The user's password."
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"Active","Inactive","Pending","Terminated"},
 *         description="The status of the user (Active,Inactive,Pending,Terminated)."
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The email address of the user."
 *     )
 * )
 */
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can adjust the authorization logic as per your needs
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'password'  => 'required|string|min:8',
            'status'    => 'required|in:Active,Inactive,Pending,Terminated',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'     => 'The name field is required.',
            'name.string'       => 'The name field must be a string.',
            'name.max'          => 'The name field must not exceed 255 characters.',
            'email.required'    => 'The email field is required.',
            'email.email'       => 'The email field must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.string'   => 'The password field must be a string.',
            'password.min'      => 'The password must be at least 8 characters.',
            'status.required'   => 'The status field is required.',
            'status.in'         => 'The status field must be either Active,Inactive,Pending or Terminated.',
        ];
    }
}
