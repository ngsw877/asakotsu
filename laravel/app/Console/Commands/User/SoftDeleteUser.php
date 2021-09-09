<?php

namespace App\Console\Commands\User;

use App\Services\User\UserServiceInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SoftDeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:soft-delete-user {userName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '指定したアカウントを論理削除します。';

    private UserServiceInterface $userService;

    /**
     * Create a new command instance.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(): int
    {
        $userName = $this->argument('userName');

        return DB::transaction(function () use ($userName) {
            $user = $this->userService->delete($userName);

            echo 'アカウント「' . $user->name . '」を論理削除しました。' . PHP_EOL;

            return 0;
        });
    }
}
