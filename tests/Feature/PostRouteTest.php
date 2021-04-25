<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRouteTest extends TestCase
{
    use RefreshDatabase;

    // TODO: 針對 API route 撰寫測試

    /**
     * @test
     *
     * 參數型態格式錯誤訊息測試
     */
    public function postsRequestValidation()
    {
        User::factory()->count(3)->create()->each(function ($user, $key) {
            $post_update_data = [];

            switch ($key) {
                case 0:
                    $post_update_data = [
                        'user_id'      => $user->id,
                        'category'     => '旅行',
                        'content'      => '旅行內容',
                        'published_at' => '2021-04-24 13:10:10',
                    ];

                    break;
                case 1:
                    $post_update_data = [
                        'user_id'      => $user->id,
                        'category'     => '烹飪',
                        'content'      => '烹飪內容',
                        'published_at' => '2021-04-24 13:20:20',
                    ];

                    break;
                case 2:
                    $post_update_data = [
                        'user_id'      => $user->id,
                        'category'     => '汽車',
                        'content'      => '汽車內容',
                        'published_at' => '2021-04-24 13:30:30',
                    ];
                    break;
            }

            Post::factory()->count(5 - $key)->create($post_update_data);
        });

        $response = $this->call('GET', route('posts'), [
            'user_id'            => 0,
            'category'           => 1,
            'content'            => 1,
            'published_at_start' => '2021-02-24',
            'published_at_end'   => '2021-02-24 13',
            'per_page'           => '十',
            'current_page'       => '一',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                "result" => "error",
                "errors" => [
                    "user_id"            => [
                        0 => "作者編號，不存在",
                    ],
                    "category"           => [
                        0 => "文章分類，必須為字串",
                    ],
                    "content"            => [
                        0 => "文章內容，必須為字串",
                    ],
                    "published_at_start" => [
                        0 => "發佈起始時間，格式必須為Y-m-d H:i:s (ex: 2021-01-01 13:01:01)",
                    ],
                    "published_at_end"   => [
                        0 => "發佈結束時間，格式必須為Y-m-d H:i:s (ex: 2021-01-01 13:01:01)",
                    ],
                    "per_page"           => [
                        0 => "指定頁數，必須為數字",
                    ],
                    "current_page"       => [
                        0 => "每頁資料比數，必須為數字",
                    ],
                ],
            ]);
    }

    /**
     * @test
     *
     * 無參數測試
     */
    public function postsNoParameter()
    {
        $response = $this->call('GET', route('posts'));

        $response
            ->assertStatus(200)
            ->assertJsonCount(12, 'data');
    }

    /**
     * @test
     *
     * 作者編號參數測試
     */
    public function postsUserIdParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'user_id' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    /**
     * @test
     *
     * 文章分類參數測試
     */
    public function postsCategoryParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'category' => '烹飪',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }

    /**
     * @test
     *
     * 文章內容參數測試
     */
    public function postsContentParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'content' => '汽車',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /**
     * @test
     *
     * 發佈時間區間參數測試
     */
    public function postsPublishedAtRangeParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'published_at_start' => '2021-04-24 13:10:10',
            'published_at_end'   => '2021-04-24 13:30:30',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(12, 'data');
    }

    /**
     * @test
     *
     * 發佈起始時間參數測試
     */
    public function postsPublishedAtStartParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'published_at_start' => '2021-04-24 13:20:20',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(7, 'data');
    }

    /**
     * @test
     *
     * 發佈結束時間參數測試
     */
    public function postsUsePublishedAtEndParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'published_at_end' => '2021-04-24 13:20:20',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(9, 'data');
    }

    /**
     * @test
     *
     * 每頁資料筆數參數測試
     */
    public function postsPerPageParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'user_id'            => 1,
            'category'           => '旅行',
            'content'            => '旅行',
            'published_at_start' => '2021-04-24 13:10:10',
            'published_at_end'   => '2021-04-24 13:10:10',
            'per_page'           => '1',
            'current_page'       => '1',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    /**
     * @test
     *
     * 指定頁數參數測試
     */
    public function postsCurrentPageParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'user_id'            => 1,
            'category'           => '旅行',
            'content'            => '旅行',
            'published_at_start' => '2021-04-24 13:10:10',
            'published_at_end'   => '2021-04-24 13:10:10',
            'per_page'           => '4',
            'current_page'       => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    /**
     * @test
     *
     * 所有參數測試
     */
    public function postsAllParameter()
    {
        $response = $this->call('GET', route('posts'), [
            'user_id'            => 1,
            'category'           => '旅行',
            'content'            => '旅行',
            'published_at_start' => '2021-04-24 13:10:10',
            'published_at_end'   => '2021-04-24 13:10:10',
            'per_page'           => '3',
            'current_page'       => '2',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    /**
     * @test
     *
     * 10012筆找內容包含旅遊的查詢時間測試
     */
    // public function postsPressureTest()
    // {
    //     User::factory()->count(10)->create()->each(function ($user) {
    //         Post::factory()->count(1000)->create([
    //             'user_id' => $user->id,
    //         ]);
    //     });
    //
    //     $start = microtime(true);
    //
    //     $response = $this->call('GET', route('posts'), [
    //         'content' => '汽車',
    //     ]);
    //
    //     $time = microtime(true) - $start;
    //
    //
    //     dump('10012筆找內容包含旅遊的查詢時間: '.$time.'秒');
    //
    //     $response
    //         ->assertStatus(200)
    //         ->assertJsonCount(3, 'data');
    // }
}
