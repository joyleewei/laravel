<?php
use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $users = User::all();
        $first_user = $users->first();
        $first_user_id = $first_user->id;

        // 获取去掉ID 为1 的所有用户ID 数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除了 1号用户以外的所有用户
        $first_user->follow($follower_ids);

        // 除了 1号用户以外的所有用户都来关注1号用户
        foreach($followers as $follower){
            $follower->follow($first_user_id);
        }
    }
}