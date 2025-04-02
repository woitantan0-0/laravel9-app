<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Task;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * リクエストの内容に基づいた権限チェックを行うメソッド
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * バリデーションルールを定義するメソッド
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $status_rule = Rule::in(array_keys(Task::STATUS));
        return [
            'title' => 'required|max:100',
            'description' => 'nullable|max:500',
            'status' => 'integer|nullable|' . $status_rule,
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * リクエストのnameなどの値を再定義するメソッド
     *
     * @return array<string>
     */
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'description' => '説明文',
            'status' => '状態',
            'due_date' => '期限日',
        ];
    }

    /**
     * FormRequestクラス単位でエラーメッセージを定義するメソッド
     *
     * @return array<string>
     */
    public function messages()
    {
        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);
        $status_labels = implode('、', $status_labels);

        return [
            /* ルールに違反した場合にエラーメッセージを出力する */
            'status.in' => ':attribute には ' . $status_labels . ' のいずれかを指定してください。',
            // 'due_date.after_or_equal':'項目名.ルール内容'
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
