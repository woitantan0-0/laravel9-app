<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * ステータス（状態）定義
     * 
     */
    const STATUS = [
        1 => [ 'label' => '未対応', 'class' => 'label-warning' ],
        2 => [ 'label' => '対応中', 'class' => 'label-info' ],
        3 => [ 'label' => '完了', 'class' => '' ],
    ];

    /**
     * ステータス（状態）ラベルのアクセサメソッド
     * 
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }

    /**
     * ステータス（状態）ラベルの色を付けるHTML用クラスのアクセサメソッド
     * 
     * @return string
     */
    public function getStatusClassAttribute()
    {
        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }

    /**
     * 期限日のフォーマットを変えるアクセサメソッド
     * 
     * @return string
     */
    public function getFormatDueDateAttribute()
    {
        $status = $this->attributes['due_date'];

        return Carbon::createFromFormat('Y-m-d', $status)->format('Y/m/d');
    }
}
