<?php

namespace App\Console\Commands\User;

use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Console\Command;

class SoftDeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:soft-delete-user {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '指定したアカウントを論理削除します。';

    private UserRepositoryInterface $userRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(): int
    {
        $userId = $this->argument('userId');

        $user = $this->userRepository->find($userId);

        $result = $this->userRepository->delete($user);

        if ($result) {
            echo 'アカウント「' . $user->name . '」を論理削除しました。' . PHP_EOL;
        }

        return 0;
    }
}
